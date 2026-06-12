# Deployment & CI/CD

This project ships with a GitHub Actions pipeline ([.github/workflows/ci-cd.yml](.github/workflows/ci-cd.yml))
and a three-environment branch strategy.

## Branch strategy

| Branch | Purpose | Pipeline |
|---|---|---|
| `main` | Integration / default branch | CI (test + build) |
| `testing` | QA / feature integration testing | CI → **auto-deploy to testing** |
| `staging` | Pre-production preview | CI → **auto-deploy to staging** |
| `production` | Live site | CI → **auto-deploy to production** (gated by approval) |

Typical flow: open PRs into `testing` → merge `testing` into `staging` to preview → merge
`staging` into `production` to release.

## What the pipeline does

**On every push / PR** to `main`, `testing`, `staging`, `production` it runs the `test` job:

1. PHP 8.2 + Composer install (cached)
2. `cp .env.example .env` + `php artisan key:generate`
3. Node 20 + `npm ci` + `npm run build` (compiles the Vite website & dashboard bundles)
4. `php artisan test` (Pest/PHPUnit, SQLite in-memory)

**On push to `testing`, `staging`, or `production`** (after `test` passes) it runs the matching
deploy job (`deploy-testing`, `deploy-staging`, or `deploy-production`), which SSHes into the
target server and pulls + builds + migrates.

## Required configuration (GitHub repo settings)

Create three **Environments** (Settings → Environments): `testing`, `staging`, and `production`.
Add **required reviewers** to `production` (and optionally `staging`) so releases need manual approval.

Add these **secrets** to each environment (Settings → Environments → <env> → Secrets):

| Secret | Description |
|---|---|
| `SSH_HOST` | Server hostname / IP |
| `SSH_USER` | SSH user |
| `SSH_KEY` | Private SSH key with deploy access |
| `SSH_PORT` | SSH port (optional, defaults to 22) |
| `DEPLOY_PATH` | Absolute path to the app on the server |

The server must already have a clone of this repo at `DEPLOY_PATH`, with PHP 8.2, Composer,
Node and a configured `.env` (the deploy step never overwrites `.env`).

> No server yet? The `test` job still runs on every branch. Deploy jobs only trigger on their
> matching branch push; until each environment's secrets exist, that deploy step will fail
> while CI on other branches keeps working.

## Running locally

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build      # or: npm run dev
php artisan serve
php artisan test
```

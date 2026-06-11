# LegalConsaltent — Complete Development Plan
**Stack:** Laravel 12 · PHP 8.2 · MySQL · Blade · Tailwind · Alpine.js · Spatie Permissions
**Date:** June 2026

---

## 1. Product Vision

A lawyer directory + content platform + practice management system:

- **Visitors** browse lawyer profiles (bio, qualifications, experience, portfolio, reviews), read articles, watch videos.
- **Lawyers** manage their public profile, write articles, upload videos, AND (new) manage their team members, clients, cases, and schedule.
- **Clients** (new role, not yet built) log in to see their lawyer's schedule, their own cases, hearings, and documents.
- **Super Admin** manages lawyers, moderates reviews/comments, views analytics.

---

## 2. Current Status Audit

### ✅ Built & Working
| Area | Details |
|---|---|
| Public site | Home, find-lawyers (load-more, view-time tracking), lawyer profile, how-it-works |
| Blog/Articles | Full system: posts, categories, tags, author pages, search, nested comments + moderation |
| Videos | YouTube video CRUD (lawyer), public video pages, view-time tracking |
| Reviews | Store, approve/reject, feature toggle, moderation dashboard |
| Profiles | Lawyer profile edit, education CRUD, experience CRUD, portfolio display |
| Dashboards | Super admin dashboard (analytics), lawyer dashboard |
| Analytics | Visitor, UserActivity, VideoView tracking |
| Auth/Roles | Breeze + Spatie (super_admin, lawyer, client, user roles seeded) |

### ❌ Missing — the entire practice management module
All these **migrations are commented out** (empty stubs), models are shells, and there are no controllers/routes/views:

- `team_members` — lawyer's team with profiles shown publicly
- `clients` — client role functionality
- `legal_cases` — case management
- `case_documents`, `case_notes`, `case_hearings` — case detail
- `pages` — CMS pages (about, terms, privacy)
- **Schedule/calendar** — no table exists at all (client must see lawyer's schedule per vision)

### 🐛 Bugs to fix
1. `blog-posts` resource registered **twice** in web.php (BlogController + BlogPostController) — remove the BlogController registration and delete/merge that controller
2. `profile.edit` / `profile.update` route names **duplicated** (lines 51–53 vs 64–66 of web.php)
3. **No role middleware** on dashboard routes — `lawyers` resource, blog-categories, reviews moderation all accessible to any authenticated user. Wrap admin-only routes in `role:super_admin`, lawyer routes in `role:lawyer|super_admin`

---

## 3. Development Phases

> Order: fix bugs → secure routes → build the missing module bottom-up (DB → backend → views), client side last since it depends on cases existing.

### Phase 0 — Bug Fixes & Route Security (Half day)
1. Remove duplicate `Route::resource('blog-posts', BlogController::class)`; delete or merge `BlogController`
2. Fix duplicate `profile.edit`/`profile.update` names (rename lawyer ones or remove redundant pair)
3. Restructure web.php middleware groups:
   - `role:super_admin` → lawyers resource, blog-categories, reviews moderation, comments moderation
   - `role:lawyer|super_admin` → blog-posts, educations, experiences, videos, lawyer profile
   - `role:client` → (reserved for Phase 4)
4. `php artisan route:list` — verify no duplicate names, test as each role

> ✅ **Phase 0 Changes/integration Successfully done in project** — BlogController deleted, duplicate profile.* names removed, routes grouped under role:super_admin / role:lawyer|super_admin, route:list shows zero duplicate names. (Note: videos kept under role:lawyer only because VideoController requires the lawyer relation.)

### Phase 1 — Database Foundation for Practice Management (Day 1)
Fill in the commented-out migrations:

**team_members:** id, uuid, lawyer_id FK, name, designation (e.g., Associate, Paralegal, Junior Counsel), email, phone, photo, bio, qualifications (text), years_of_experience, is_active, order, timestamps, softDeletes

**clients:** id, uuid, user_id FK, lawyer_id FK (primary lawyer), phone, cnic (nullable — PK market), address, city, notes (lawyer's private notes), is_active, timestamps, softDeletes

**legal_cases:** id, uuid, lawyer_id FK, client_id FK, team_member_id FK nullable (assigned member), case_number, title, type (civil/criminal/family/corporate/tax), court_name, judge_name nullable, description, status (pending/active/on_hold/won/lost/closed), filed_date, next_hearing_date nullable, is_visible_to_client (bool, default true), timestamps, softDeletes

**case_documents:** id, case_id FK, uploaded_by (user_id), title, file_path, file_type, file_size, is_visible_to_client (bool), timestamps

**case_notes:** id, case_id FK, user_id FK, note, is_private (bool — hidden from client), timestamps

**case_hearings:** id, case_id FK, hearing_date, hearing_time, court_name, room nullable, purpose, outcome nullable (text, filled after), status (scheduled/completed/adjourned/cancelled), timestamps

**NEW — schedules:** id, lawyer_id FK, title, type (hearing/meeting/consultation/personal), start_datetime, end_datetime, location nullable, case_id FK nullable, is_public (bool — visible on public profile as availability), timestamps

**pages:** id, slug, title, content (longtext), meta_description, is_published, timestamps

Then: fill all shell models with fillable, casts, relationships. Update Lawyer model: `teamMembers()`, `clients()`, `cases()`, `schedules()`. Seeder: 3 lawyers each with 2–3 team members, 3 clients, 2–4 cases with hearings (Pakistani names, realistic PK courts — e.g., Sindh High Court, City Courts Karachi).

**Test:** `php artisan migrate:fresh --seed` clean, tinker through relationships.

> ✅ **Phase 1 Changes/integration Successfully done in project** — All 7 stub migrations filled + new schedules migration, 8 models written with uuid boot/casts/relationships, Lawyer model extended, PracticeManagementSeeder created (3 lawyers × 2 team members, 3 clients, 3 cases, hearings, schedules — Pakistani names & Sindh courts). `migrate:fresh --seed` runs clean; relationships verified via tinker. DB backup saved at `storage/backup_before_phase1_20260611_170158.sql`.

### Phase 2 — Lawyer: Team Management (Day 2)
1. `TeamMemberController` (resource, scoped to auth lawyer) + routes under `role:lawyer`
2. Views `dashboard/team/` → index (cards/table), create, edit — photo upload to `storage/app/public/team`
3. **Public profile integration:** add Team section to `website/lawyer_profile.blade.php` showing active members (photo, name, designation, qualifications) ordered by `order`

**Test:** Add team members as lawyer → visible on public profile.

> ✅ **Phase 2 Changes/integration Successfully done in project** — TeamMemberController (scoped to auth lawyer, photo upload to storage/app/public/team), views dashboard/team (index cards, create, edit), "My Team" sidebar link, "Our Team" section on public lawyer profile. Smoke-tested: public profile renders seeded team members (HTTP 200).

### Phase 3 — Lawyer: Clients & Cases (Days 3–4)
1. `ClientController` (lawyer creates client → creates User with client role + Client record, sends credentials or sets password)
2. Views `dashboard/clients/` → index (search), create, edit, show (client detail + their cases)
3. `CaseController` (resource scoped to lawyer) + close/status-change actions
4. Views `dashboard/cases/` → index (filter by status/type/client), create, edit, show with tabs:
   - **Overview** | **Documents** (upload, toggle client visibility) | **Notes** (private toggle) | **Hearings** (add, mark outcome)
5. Hearing creation auto-creates a `schedules` entry (type=hearing)

**Test:** Create client → create case → upload doc → add private note + client-visible note → schedule hearing → mark outcome.

> ✅ **Phase 3 Changes/integration Successfully done in project** — Lawyer\ClientController (store creates User+Client in transaction, search index, show with cases) and Lawyer\CaseController (resource + status PATCH + documents upload/visibility-toggle/delete + notes with private flag + hearings with outcome). Views dashboard/clients & dashboard/cases; case show uses Bootstrap tabs (Overview | Documents | Notes | Hearings). Hearing creation auto-creates a Schedule row (type=hearing) in the same transaction and re-syncs next_hearing_date. Verified: all pages 200 as lawyer, cross-lawyer access 403, hearing→schedule automation works.

### Phase 4 — Lawyer: Schedule/Calendar (Day 5)
1. `ScheduleController`: index (calendar view), getEvents (JSON — merges schedules + case hearings), store, update, destroy
2. View `dashboard/schedule/index.blade.php` — FullCalendar 6 CDN, Alpine modal for add/edit, color-coded by type
3. **Public availability:** on public lawyer profile, show "Upcoming availability" or busy slots from `is_public` schedule entries (no details, just blocks)

**Test:** Hearings from Phase 3 appear automatically; add a consultation; verify public profile shows availability.

> ✅ **Phase 4 Changes/integration Successfully done in project** — Lawyer\ScheduleController (index, getEvents JSON, store/update/destroy with ownership checks), dashboard/schedule/index.blade.php with FullCalendar 6 CDN + Bootstrap modal, color-coded by type (hearing red, meeting blue, consultation green, personal grey); hearings are read-only on the calendar (managed from case page). Public profile shows "Upcoming Availability" blocks from is_public entries — verified no case details leak. Sidebar "Schedule" link added.

### Phase 5 — Client Portal (Days 6–7)
New role experience. Routes under `role:client`, prefix `client/`:

1. `Client\DashboardController` — my lawyer card, my cases summary, next hearing alert
2. `Client\CaseController` — index (own cases where is_visible_to_client), show (read-only: status, hearings timeline, client-visible documents + notes)
3. `Client\ScheduleController` — view lawyer's public schedule + own case hearings
4. Views: `client/dashboard.blade.php`, `client/cases/index.blade.php`, `client/cases/show.blade.php`, `client/schedule.blade.php`
5. Update navigation/sidebar to render per-role menus
6. Update `DashboardController@index` to route client role → client dashboard

**Test:** Login as seeded client → see only own cases → cannot see private notes or hidden documents → cannot access /dashboard lawyer routes (403).

> ✅ **Phase 5 Changes/integration Successfully done in project** — Client\DashboardController (lawyer card, case stats, next-hearing alert), Client\CaseController (own visible cases only; show excludes private notes & hidden documents server-side), Client\ScheduleController (public slots + own hearings). Views under resources/views/client. Sidebar renders per-role menus (client: My Cases, Schedule); main dashboard redirects client role → client.dashboard. Also fixed pre-existing `@role('sper_admin')` typo in navigation so super admin & client get a working user dropdown with POST logout. Verified: private note/hidden doc never leak, lawyer routes 403 for client, other clients' cases 403.

### Phase 6 — CMS Pages & Polish (Day 8)
1. `PageController` (super_admin CRUD) + public route `Route::get('/page/{slug}')` — for About, Terms, Privacy, FAQ
2. Footer links to pages
3. Form Requests for all new store/update endpoints
4. Policies: CasePolicy, ClientPolicy, TeamMemberPolicy (lawyer owns, client views own)
5. Flash message component consistency
6. Empty states for all new index pages
7. Full regression: `migrate:fresh --seed`, test as super_admin / lawyer / client / guest

> ✅ **Phase 6 Changes/integration Successfully done in project** — PageController (super_admin CRUD at /pages + public `/page/{slug}`), PageSeeder (About, Terms, Privacy, FAQ), dynamic footer links to published pages, Form Requests (StoreClientRequest, UpdateClientRequest, CaseRequest, TeamMemberRequest, ScheduleRequest, PageRequest), Policies (LegalCasePolicy, ClientPolicy, TeamMemberPolicy — auto-discovered, wired via Gate). Also fixed pre-existing bugs found during regression: public `/lawyers` route was shadowed by the admin resource (removed; footer/nav use find-lawyeres), and LawyerController pointed at non-existent `lawyers.show`/`lawyers.edit` views (now dashboard.lawyers.*). Full regression passed for guest / super_admin / lawyer / client / plain user.

---

## 4. Cursor / Claude Code Prompts (Copy-Paste)

### Prompt — Phase 0 (Fixes)
```
In routes/web.php: (1) Remove the duplicate Route::resource('blog-posts',
BlogController::class) — keep only the BlogPostController one — and delete
app/Http/Controllers/BlogController.php after confirming nothing references
it. (2) Fix duplicate route names: profile.edit and profile.update are
registered twice; keep the /profile pair and remove the lawyer/profile
duplicate pair (lawyer profile already has lawyer.profile.* names). (3)
Reorganize the auth group into three middleware groups: role:super_admin for
lawyers resource, blog-categories, reviews moderation and comment moderation
routes; role:lawyer|super_admin for blog-posts, educations, experiences and
the existing videos group; leave profile routes under plain auth. Run
php artisan route:list and confirm zero duplicate names.
```

### Prompt — Phase 1 (Migrations + Models)
```
The migrations for team_members, clients, legal_cases, case_documents,
case_notes, case_hearings and pages are commented-out stubs — implement them
with this schema: [paste schema from plan Phase 1]. Also create a new
migration create_schedules_table with: lawyer_id FK, title, type enum
(hearing/meeting/consultation/personal), start_datetime, end_datetime,
location nullable, case_id FK nullable, is_public boolean default false.
Then fill the shell models (TeamMember, Client, LegalCase, CaseDocument,
CaseNote, CaseHearing, Page) and new Schedule model with fillable, casts,
uuid boot logic matching the Lawyer model pattern, and relationships. Add
teamMembers, clients, cases, schedules relations to the Lawyer model.
Finally extend DatabaseSeeder: for each existing seeded lawyer create 2 team
members, 3 clients (with user accounts, client role, password 'password'),
and 3 cases each with 2 hearings — use Pakistani names and Karachi/Sindh
court names. Run migrate:fresh --seed and fix any errors.
```

### Prompt — Phase 3 (Clients & Cases)
```
Create ClientController and CaseController in app/Http/Controllers/Lawyer
namespace, routes under middleware role:lawyer prefix dashboard. Read the
clients and legal_cases migrations first. ClientController: full resource
scoped to auth()->user()->lawyer->id; store creates a User (role client) +
Client record in a transaction. CaseController: resource + a status PATCH
route; show loads documents, notes, hearings. Build Blade views under
resources/views/dashboard/clients and dashboard/cases reusing the existing
layouts/dashboard.blade.php and sidebar style — case show page uses Alpine
tabs: Overview, Documents (upload form, visibility toggle), Notes (private
checkbox), Hearings (add form, outcome field). Document uploads go to
storage/app/public/cases/{case_uuid}, validate mimes pdf,doc,docx,jpg,png
max 10MB. When a hearing is created also create a Schedule row type=hearing
for the lawyer in the same transaction.
```

### Prompt — Phase 5 (Client Portal)
```
Build the client portal. Routes: middleware ['auth','role:client'], prefix
'client', names client.*. Controllers in App\Http\Controllers\Client:
DashboardController@index (my lawyer info, case count by status, next
upcoming hearing), CaseController@index and @show (only cases where
client_id = auth client AND is_visible_to_client true, else 403; show
excludes private notes and non-client-visible documents),
ScheduleController@index (lawyer's is_public schedule entries + hearings of
my own cases). Views under resources/views/client using the dashboard
layout but a client-specific sidebar partial. Update the main
DashboardController@index to redirect users with client role to
client.dashboard. Update layouts/sidebar.blade.php to render menu items
per role using hasRole checks.
```

---

## 5. Post-MVP Ideas

1. **WhatsApp click-to-chat** on lawyer profiles + hearing reminders via WhatsApp API (high impact in PK)
2. **Hearing reminder notifications** — Laravel scheduler: email/SMS to client + lawyer 24h before
3. **Online consultation booking** — clients book free slots from public schedule
4. **Urdu/Roman Urdu language toggle**
5. **Lawyer analytics page** — you already track view_count, visitor data, video views; surface it
6. **Featured lawyers monetization** — `is_featured` flag already exists on lawyers table
7. **Case fee/payment tracking** (simple ledger per case)

---

## 6. Final Testing Checklist

- [x] No duplicate route names (`php artisan route:list`) — verified
- [x] Regular `user` role cannot access any dashboard module — verified (403 on lawyer/admin/client routes)
- [x] Lawyer cannot see another lawyer's clients/cases/team (scoping) — verified (403)
- [x] Client sees only own visible cases; private notes never leak — verified server-side
- [x] Hidden documents (is_visible_to_client=false) invisible to client — verified
- [x] Hearing creation appears on lawyer calendar automatically — verified (Schedule row created in same transaction)
- [x] Team members render on public lawyer profile — verified
- [x] Public schedule shows availability without leaking case details — verified
- [x] Blog, videos, reviews still work after route restructure (regression) — verified (all 200)
- [x] `migrate:fresh --seed` runs clean end-to-end — verified

---

# Website Refactor — Components + Centralized Design (June 2026)

Convert the public website to reusable Blade components (`<x-website.*>`), centralized design tokens, and separated CSS/JS files via Vite — zero visual regressions.

### Phase A — Foundation (layout component, tokens, JS modules, Vite)

> ✅ **Phase A Successfully done** — Created `resources/css/website/{_tokens,_base,website}.css` (tokens hold the existing palette/fonts/spacing/shadows), `resources/js/website/website.js` + modules `flash-messages.js` & `auth-manager.js` (extracted from the inline layout scripts), added both as Vite inputs, and built a `<x-website.layout.master>` component with `title`/`description`/`ogImage` props (all SEO/JSON-LD/favicon preserved). Switched all 11 website pages from `@extends` to the component — each now has a proper per-page `<title>` & meta description. `npm run build` clean; every page renders 200 with vite assets + flash payload; all Blade views compile.
### Phase B — Atoms (ui/: button, badge, avatar, rating, image, inputs, section-heading, icon-box)

> ✅ **Phase B Successfully done** — Created 10 anonymous UI atoms under `components/website/ui/` (button, badge, avatar with initials fallback, rating with half-stars, image with ratio/lazy/fallback, input, textarea, select, section-heading, icon-box) styled in `components/{buttons,badges,forms,cards}.css` using only `_tokens.css` variables (`lc-` prefixed). Migrated `home.blade.php` + `how_it_works.blade.php` to the atoms (hero buttons, section headings, how-it-works steps as icon-boxes), moved their inline styles + the old `public/website/css/home.css` link into `resources/css/website/pages/home.css`. Both pages render 200 with zero inline `<style>`.
### Phase C — Cards & Sections (lawyer/blog/video/review/team cards, hero, empty-state, pagination + loadMore fix)

> ✅ **Phase C Successfully done** — Built `cards/lawyer-card`, `cards/blog-card` (with optional `showTags`), `cards/video-card`, and `sections/empty-state` molecules (each self-contained with its grid column, composed from the atoms). Replaced hand-coded grids in: home featured lawyers, `lawyers.blade.php` listing, `blog/{index,category,tag}`, `videos/index`. Created `website/partials/lawyer-grid.blade.php` and updated `WebsiteLawyersController@loadMore` to render it, so AJAX-appended cards match — then **deleted** `lawyers_card.blade.php`. lawyer/blog/video card CSS added under `components/`. All pages render 200; load-more verified. (review-card & team-member-card are built in Phase D where the profile consumes them.)
### Phase D — Split lawyer_profile.blade.php into partials (<100 lines)

> ✅ **Phase D Successfully done** — Split `lawyer_profile.blade.php` from **938 → 28 lines** (orchestrator only). Created 10 partials under `website/partials/profile/` (`_header, _about, _specializations, _experience, _education, _portfolio, _team, _availability, _reviews, _sidebar`); team & reviews use new `cards/team-member-card` + `cards/review-card` components. Migrated both inline `<style>` blocks **and** the external `public/website/css/profile.css` into `resources/css/website/pages/lawyer-profile.css` (cascade order preserved, tokenized). Moved the two inline `<script>` blocks into `js/website/modules/track-time.js` (generic, reads `body[data-track-url]` + csrf meta) and `js/website/pages/lawyer-profile.js` (review form) — both self-guard and ship in the one bundle. Verified: profile renders 200 with zero inline `<style>`/`<script>`, team/review cards present, tracking wired.
### Phase E — Remaining pages, dead CSS cleanup, build + parity check

> ✅ **Phase E Successfully done** — Migrated every remaining inline `<style>` into page CSS (`pages/blog.css`, `pages/videos.css`) and extracted remaining inline JS into modules (`load-more.js`, `comments.js`) and page scripts (`video-show.js`) — all guarded, all in the one bundle. Converted `auth/register` + `welcome` to the layout component and **deleted the old `website/layout/master.blade.php`**. Deleted dead public assets: `global.css`, `home.css`, `profile.css`, `browse_lawyers.css`, `home.js`. Fixed two pre-existing bugs along the way: blog-show comment CSS was wrapped in `<script>` (never applied) and the video-show tracking script had formatter-mangled Blade (`{ { $video - > duration } }`, a JS error) — both now work. `npm run build` clean; all 12 public pages + dashboard render 200.

### Definition of Done
- [x] 0 `<style>` tags in website blade files — verified (grep ZERO)
- [x] 0 logic `<script>` tags in website blade files (JSON-LD allowed) — verified (grep ZERO; JSON-LD lives in the layout component)
- [x] All buttons/inputs/badges/cards on website are components — atoms + card molecules in use
- [x] lawyer_profile.blade.php < 100 lines — now 28 lines
- [x] One palette change in _tokens.css updates whole site — all component/page CSS reference tokens only
- [x] Per-page `<title>` and meta description on every page — via layout component props
- [x] load-more, view-time tracking, comments, review form all still work — wired via data-attributes + guarded modules
- [x] `npm run build` clean; old duplicated public CSS removed — 5 dead files deleted

---

## Website Refactor — Final Structure

```
resources/
├── css/website/
│   ├── website.css            ← Vite entry (imports all below in order)
│   ├── _tokens.css            ← design tokens (palette/fonts/spacing/shadows)
│   ├── _base.css              ← typography, navbar/footer, legacy badges
│   ├── components/            ← buttons, badges, forms, cards, lawyer-card,
│   │                            blog-card, video-card, team-card
│   └── pages/                 ← home, lawyer-profile, blog, videos
├── js/website/
│   ├── website.js             ← Vite entry; wires all modules (each self-guards)
│   ├── modules/               ← flash-messages, auth-manager, track-time,
│   │                            load-more, comments
│   └── pages/                 ← lawyer-profile, video-show
└── views/components/website/
    ├── layout/master.blade.php           ← <x-website.layout.master> (title/description/ogImage)
    ├── ui/                    ← button, badge, avatar, rating, image,
    │                            input, textarea, select, section-heading, icon-box
    ├── cards/                 ← lawyer-card, blog-card, video-card,
    │                            team-member-card, review-card
    └── sections/              ← empty-state
```
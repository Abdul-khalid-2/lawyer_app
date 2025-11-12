Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('gender')->nullable();
    $table->string('email')->unique();
    $table->enum('role', ['super_admin', 'lawyer', 'client'])->default('client');
    $table->string('phone')->nullable();
    $table->string('profile_image')->nullable();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->boolean('is_active')->default(true);
    $table->rememberToken();
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('lawyers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->uuid('uuid')->unique();
    $table->string('bar_number')->nullable()->unique();
    $table->string('license_state')->nullable();
    $table->text('bio')->nullable();
    $table->integer('years_of_experience')->default(0);
    $table->string('firm_name')->nullable();
    $table->string('website')->nullable();
    $table->text('address')->nullable();
    $table->string('city')->nullable();
    $table->string('state')->nullable();
    $table->string('zip_code')->nullable();
    $table->string('country')->nullable();
    $table->decimal('hourly_rate', 10, 2)->nullable();
    $table->text('services')->nullable();
    $table->text('awards')->nullable();
    $table->boolean('is_verified')->default(false);
    $table->boolean('is_featured')->default(false);
    $table->integer('view_count')->default(0);
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('specializations', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('icon')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

Schema::create('educations', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
    $table->string('degree');
    $table->string('institution');
    $table->year('graduation_year');
    $table->text('description')->nullable();
    $table->integer('order')->default(0);
    $table->timestamps();
});

Schema::create('experiences', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
    $table->string('position');
    $table->string('company');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->boolean('is_current')->default(false);
    $table->text('description')->nullable();
    $table->integer('order')->default(0);
    $table->timestamps();
});

Schema::create('portfolios', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('case_type')->nullable();
    $table->string('outcome')->nullable();
    $table->year('year');
    $table->text('challenges')->nullable();
    $table->text('solution')->nullable();
    $table->string('client_name')->nullable();
    $table->decimal('case_value', 15, 2)->nullable();
    $table->string('document_url')->nullable();
    $table->boolean('is_public')->default(true);
    $table->boolean('is_featured')->default(false);
    $table->timestamps();
});

Schema::create('reviews', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->integer('rating');
    $table->string('title')->nullable();
    $table->text('review');
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->boolean('is_featured')->default(false);
    $table->timestamps();
});

later I will add 
// Schema::create('case_hearings', function (Blueprint $table) {
//     $table->id();
//     $table->timestamps();
// });
// Schema::create('case_notes', function (Blueprint $table) {
//     $table->id();
//     $table->timestamps();
// });
// Schema::create('case_documents', function (Blueprint $table) {
//     $table->id();
//     $table->timestamps();
// });
// Schema::create('legal_cases', function (Blueprint $table) {
//     $table->id();
//     $table->timestamps();
// });
        // Schema::create('clients', function (Blueprint $table) {
//     $table->id();
//     $table->timestamps();
// });
    // Schema::create('team_members', function (Blueprint $table) {
//     $table->id();
//     $table->timestamps();
// });

Schema::create('blog_categories', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('icon')->nullable();
    $table->text('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

Schema::create('blog_posts', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique();
    $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
    $table->foreignId('blog_category_id')->nullable()->constrained()->onDelete('set null');
    $table->string('title');
    $table->string('slug')->unique();
    $table->json('structure')->nullable();
    $table->text('excerpt')->nullable();
    $table->longText('content');
    $table->string('featured_image')->nullable();
    $table->json('tags')->nullable();
    $table->integer('view_count')->default(0);
    $table->integer('read_time')->default(5);
    $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
    $table->timestamp('published_at')->nullable();
    $table->text('meta_title')->nullable();
    $table->text('meta_description')->nullable();

    // Canvas elements for flexible content
    $table->json('banner')->nullable();
    $table->json('image')->nullable();
    $table->json('rich_text')->nullable();
    $table->json('text_left_image_right')->nullable();
    $table->json('custom_html')->nullable();
    $table->json('canvas_elements')->nullable();

    $table->timestamps();
});

Schema::create('visitors', function (Blueprint $table) {
    $table->id();
    $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
    $table->string('ip_address');
    $table->string('user_agent')->nullable();
    $table->string('country')->nullable();
    $table->string('city')->nullable();
    $table->string('referrer')->nullable();
    $table->string('page_visited');
    $table->integer('time_spent')->default(0); // in seconds
    $table->timestamps();
});

Schema::create('user_activities', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('activity_type');
    $table->text('description');
    $table->string('ip_address')->nullable();
    $table->text('user_agent')->nullable();
    $table->json('metadata')->nullable();
    $table->timestamps();
});

Schema::create('lawyer_specialization', function (Blueprint $table) {
    $table->id();
    $table->foreignId('lawyer_id')->constrained()->onDelete('cascade');
    $table->foreignId('specialization_id')->constrained()->onDelete('cascade');
    $table->integer('years_of_experience')->default(0);
    $table->timestamps();

    $table->unique(['lawyer_id', 'specialization_id']);
});

public function up(): void
{
    $teams = config('permission.teams');
    $tableNames = config('permission.table_names');
    $columnNames = config('permission.column_names');
    $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
    $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

    throw_if(empty($tableNames), Exception::class, 'Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
    throw_if($teams && empty($columnNames['team_foreign_key'] ?? null), Exception::class, 'Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');

    Schema::create($tableNames['permissions'], static function (Blueprint $table) {
        // $table->engine('InnoDB');
        $table->bigIncrements('id'); // permission id
        $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
        $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
        $table->timestamps();

        $table->unique(['name', 'guard_name']);
    });

    Schema::create($tableNames['roles'], static function (Blueprint $table) use ($teams, $columnNames) {
        // $table->engine('InnoDB');
        $table->bigIncrements('id'); // role id
        if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
            $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
            $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
        }
        $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
        $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
        $table->timestamps();
        if ($teams || config('permission.testing')) {
            $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
        } else {
            $table->unique(['name', 'guard_name']);
        }
    });

    Schema::create($tableNames['model_has_permissions'], static function (Blueprint $table) use ($tableNames, $columnNames, $pivotPermission, $teams) {
        $table->unsignedBigInteger($pivotPermission);

        $table->string('model_type');
        $table->unsignedBigInteger($columnNames['model_morph_key']);
        $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

        $table->foreign($pivotPermission)
            ->references('id') // permission id
            ->on($tableNames['permissions'])
            ->onDelete('cascade');
        if ($teams) {
            $table->unsignedBigInteger($columnNames['team_foreign_key']);
            $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

            $table->primary([$columnNames['team_foreign_key'], $pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                'model_has_permissions_permission_model_type_primary');
        } else {
            $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                'model_has_permissions_permission_model_type_primary');
        }

    });

    Schema::create($tableNames['model_has_roles'], static function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole, $teams) {
        $table->unsignedBigInteger($pivotRole);

        $table->string('model_type');
        $table->unsignedBigInteger($columnNames['model_morph_key']);
        $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

        $table->foreign($pivotRole)
            ->references('id') // role id
            ->on($tableNames['roles'])
            ->onDelete('cascade');
        if ($teams) {
            $table->unsignedBigInteger($columnNames['team_foreign_key']);
            $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

            $table->primary([$columnNames['team_foreign_key'], $pivotRole, $columnNames['model_morph_key'], 'model_type'],
                'model_has_roles_role_model_type_primary');
        } else {
            $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                'model_has_roles_role_model_type_primary');
        }
    });

    Schema::create($tableNames['role_has_permissions'], static function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission) {
        $table->unsignedBigInteger($pivotPermission);
        $table->unsignedBigInteger($pivotRole);

        $table->foreign($pivotPermission)
            ->references('id') // permission id
            ->on($tableNames['permissions'])
            ->onDelete('cascade');

        $table->foreign($pivotRole)
            ->references('id') // role id
            ->on($tableNames['roles'])
            ->onDelete('cascade');

        $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
    });

    app('cache')
        ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
        ->forget(config('permission.cache.key'));
}
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('blog_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('comment');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->timestamps();

            // Indexes for better performance
            $table->index('blog_post_id');
            $table->index('parent_id');
            $table->index('status');
            $table->index(['blog_post_id', 'status']);
        });
    }
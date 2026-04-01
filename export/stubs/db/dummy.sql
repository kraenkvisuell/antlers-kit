-- -------------------------------------------------------------
-- TablePlus 6.3.2(586)
--
-- https://tableplus.com/
--
-- Database: dummy
-- Generation Time: 2025-03-09 15:09:15.3480
-- -------------------------------------------------------------


DROP TABLE IF EXISTS "public"."cache";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."cache" (
    "key" varchar(255) NOT NULL,
    "value" text NOT NULL,
    "expiration" int4 NOT NULL,
    PRIMARY KEY ("key")
);

DROP TABLE IF EXISTS "public"."cache_locks";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."cache_locks" (
    "key" varchar(255) NOT NULL,
    "owner" varchar(255) NOT NULL,
    "expiration" int4 NOT NULL,
    PRIMARY KEY ("key")
);

DROP TABLE IF EXISTS "public"."collections";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS collections_id_seq;

-- Table Definition
CREATE TABLE "public"."collections" (
    "id" int8 NOT NULL DEFAULT nextval('collections_id_seq'::regclass),
    "handle" varchar(255) NOT NULL,
    "title" varchar(255) NOT NULL,
    "settings" jsonb,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."entries";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."entries" (
    "id" uuid NOT NULL,
    "site" varchar(255) NOT NULL,
    "origin_id" uuid,
    "published" bool NOT NULL DEFAULT true,
    "slug" varchar(255),
    "uri" varchar(255),
    "date" varchar(255),
    "order" int4,
    "collection" varchar(255) NOT NULL,
    "blueprint" varchar(30),
    "data" jsonb NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."failed_jobs";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS failed_jobs_id_seq;

-- Table Definition
CREATE TABLE "public"."failed_jobs" (
    "id" int8 NOT NULL DEFAULT nextval('failed_jobs_id_seq'::regclass),
    "uuid" varchar(255) NOT NULL,
    "connection" text NOT NULL,
    "queue" text NOT NULL,
    "payload" text NOT NULL,
    "exception" text NOT NULL,
    "failed_at" timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."form_submissions";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."form_submissions" (
    "id" numeric(14,4) NOT NULL,
    "form" varchar(255),
    "data" jsonb,
    "created_at" timestamp,
    "updated_at" timestamp,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."forms";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS forms_id_seq;

-- Table Definition
CREATE TABLE "public"."forms" (
    "id" int8 NOT NULL DEFAULT nextval('forms_id_seq'::regclass),
    "handle" varchar(255) NOT NULL,
    "title" varchar(255) NOT NULL,
    "settings" jsonb,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."global_set_variables";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS global_set_variables_id_seq;

-- Table Definition
CREATE TABLE "public"."global_set_variables" (
    "id" int8 NOT NULL DEFAULT nextval('global_set_variables_id_seq'::regclass),
    "handle" varchar(255) NOT NULL,
    "locale" varchar(255),
    "origin" varchar(255),
    "data" jsonb NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."global_sets";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS global_sets_id_seq;

-- Table Definition
CREATE TABLE "public"."global_sets" (
    "id" int8 NOT NULL DEFAULT nextval('global_sets_id_seq'::regclass),
    "handle" varchar(255) NOT NULL,
    "title" varchar(255) NOT NULL,
    "settings" jsonb NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."group_user";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS group_user_id_seq;

-- Table Definition
CREATE TABLE "public"."group_user" (
    "id" int8 NOT NULL DEFAULT nextval('group_user_id_seq'::regclass),
    "user_id" int8 NOT NULL,
    "group_id" varchar(255) NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."job_batches";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."job_batches" (
    "id" varchar(255) NOT NULL,
    "name" varchar(255) NOT NULL,
    "total_jobs" int4 NOT NULL,
    "pending_jobs" int4 NOT NULL,
    "failed_jobs" int4 NOT NULL,
    "failed_job_ids" text NOT NULL,
    "options" text,
    "cancelled_at" int4,
    "created_at" int4 NOT NULL,
    "finished_at" int4,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."jobs";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS jobs_id_seq;

-- Table Definition
CREATE TABLE "public"."jobs" (
    "id" int8 NOT NULL DEFAULT nextval('jobs_id_seq'::regclass),
    "queue" varchar(255) NOT NULL,
    "payload" text NOT NULL,
    "attempts" int2 NOT NULL,
    "reserved_at" int4,
    "available_at" int4 NOT NULL,
    "created_at" int4 NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."migrations";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS migrations_id_seq;

-- Table Definition
CREATE TABLE "public"."migrations" (
    "id" int4 NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
    "migration" varchar(255) NOT NULL,
    "batch" int4 NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."navigations";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS navigations_id_seq;

-- Table Definition
CREATE TABLE "public"."navigations" (
    "id" int8 NOT NULL DEFAULT nextval('navigations_id_seq'::regclass),
    "handle" varchar(255) NOT NULL,
    "title" varchar(255) NOT NULL,
    "settings" jsonb,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."password_activation_tokens";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."password_activation_tokens" (
    "email" varchar(255) NOT NULL,
    "token" varchar(255) NOT NULL,
    "created_at" timestamp(0)
);

DROP TABLE IF EXISTS "public"."password_reset_tokens";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."password_reset_tokens" (
    "email" varchar(255) NOT NULL,
    "token" varchar(255) NOT NULL,
    "created_at" timestamp(0),
    PRIMARY KEY ("email")
);

DROP TABLE IF EXISTS "public"."role_user";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS role_user_id_seq;

-- Table Definition
CREATE TABLE "public"."role_user" (
    "id" int8 NOT NULL DEFAULT nextval('role_user_id_seq'::regclass),
    "user_id" int8 NOT NULL,
    "role_id" varchar(255) NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."sessions";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."sessions" (
    "id" varchar(255) NOT NULL,
    "user_id" int8,
    "ip_address" varchar(45),
    "user_agent" text,
    "payload" text NOT NULL,
    "last_activity" int4 NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."taxonomies";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS taxonomies_id_seq;

-- Table Definition
CREATE TABLE "public"."taxonomies" (
    "id" int8 NOT NULL DEFAULT nextval('taxonomies_id_seq'::regclass),
    "handle" varchar(255) NOT NULL,
    "title" varchar(255) NOT NULL,
    "sites" jsonb,
    "settings" jsonb,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."taxonomy_terms";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS taxonomy_terms_id_seq;

-- Table Definition
CREATE TABLE "public"."taxonomy_terms" (
    "id" int8 NOT NULL DEFAULT nextval('taxonomy_terms_id_seq'::regclass),
    "site" varchar(255) NOT NULL,
    "slug" varchar(255) NOT NULL,
    "uri" varchar(255),
    "taxonomy" varchar(255) NOT NULL,
    "data" jsonb NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."tokens";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS tokens_id_seq;

-- Table Definition
CREATE TABLE "public"."tokens" (
    "id" int8 NOT NULL DEFAULT nextval('tokens_id_seq'::regclass),
    "token" varchar(255) NOT NULL,
    "handler" varchar(255) NOT NULL,
    "data" jsonb NOT NULL,
    "expire_at" timestamp(0) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."trees";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS trees_id_seq;

-- Table Definition
CREATE TABLE "public"."trees" (
    "id" int8 NOT NULL DEFAULT nextval('trees_id_seq'::regclass),
    "handle" varchar(255) NOT NULL,
    "type" varchar(255) NOT NULL,
    "locale" varchar(255),
    "tree" jsonb,
    "settings" jsonb,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."users";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS users_id_seq;

-- Table Definition
CREATE TABLE "public"."users" (
    "id" int8 NOT NULL DEFAULT nextval('users_id_seq'::regclass),
    "name" varchar(255) NOT NULL,
    "email" varchar(255) NOT NULL,
    "email_verified_at" timestamp(0),
    "password" varchar(255),
    "remember_token" varchar(100),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "super" bool NOT NULL DEFAULT false,
    "avatar" varchar(255),
    "preferences" json,
    "last_login" timestamp(0),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."sites";
-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS sites_id_seq;

-- Table Definition
CREATE TABLE "public"."sites" (
    "id" int8 NOT NULL DEFAULT nextval('sites_id_seq'::regclass),
    "handle" varchar(255) NOT NULL,
    "name" varchar(255) NOT NULL,
    "order" int8 NOT NULL DEFAULT 1,
    "url" varchar(255) NOT NULL,
    "locale" varchar(255) NOT NULL,
    "lang" varchar(255) NOT NULL,
    "attributes" varchar(255) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    
    PRIMARY KEY ("id")
);

INSERT INTO "public"."collections" ("id", "handle", "title", "settings", "created_at", "updated_at") VALUES
(1, 'pages', 'Pages', '{"dated": false, "mount": null, "sites": ["default"], "slugs": true, "inject": [], "layout": "layout", "routes": "{parent_uri}/{slug}", "sort_dir": "asc", "template": "default", "propagate": false, "revisions": false, "structure": {"root": true, "max_depth": 1}, "sort_field": null, "taxonomies": null, "search_index": null, "title_formats": [], "default_status": true, "origin_behavior": "select", "preview_targets": [{"label": "Entry", "format": "{permalink}", "refresh": true}], "past_date_behavior": "public", "future_date_behavior": "public"}', '2025-03-04 09:49:14', '2025-03-04 09:49:14');

INSERT INTO "public"."entries" ("id", "site", "origin_id", "published", "order", "slug", "uri", "date", "collection", "blueprint", "data", "created_at", "updated_at") VALUES
('4a020d65-c423-446a-b3c1-ff486f1e68c3', 'default', NULL, 't', 5, 'baz', '/baz', NULL, 'pages', 'page', '{"seo": {"browser_title": null, "meta_description": null}, "title": "Excepteur incididunt Lorem dolor", "has_hero": false, "updated_by": "a134c226-b5ed-442f-bc9d-538cbb00876c"}', '2025-02-07 14:36:58', '2025-02-07 14:36:58'),
('72846eb4-114d-4e90-b48b-609d10188b7e', 'default', NULL, 't', 4, 'foo', '/foo', NULL, 'pages', 'page', '{"seo": {"browser_title": null, "meta_description": null}, "title": "Exercitation dolore enim id", "has_hero": false, "updated_by": "a134c226-b5ed-442f-bc9d-538cbb00876c"}', '2025-03-04 09:39:10', '2025-03-04 09:39:10'),
('74d50153-f84a-4921-b6b5-67f3101ac6df', 'default', NULL, 't', 3, 'dolor', '/dolor', NULL, 'pages', 'page', '{"seo": {"browser_title": null, "meta_description": null}, "title": "Dolor", "has_hero": false, "content": [{"id": "m7xi06ka", "file": "placeholders/ocean-landscape-2.jpg", "type": "image", "ratio": "1:1", "enabled": true, "force_ratio": true, "has_subline": false, "has_topline": false}], "is_home": false, "favicons": null, "dark_mode": null, "light_mode": null, "updated_by": "a134c226-b5ed-442f-bc9d-538cbb00876c", "browser_title": null, "favicon_16x16": null, "favicon_32x32": null, "favicon_48x48": null, "favicon_96x96": null, "favicon_144x144": null, "favicon_192x192": null, "favicon_256x256": null, "favicon_512x512": null, "favicons_section": null, "meta_description": null, "favicon_dark_16x16": null, "favicon_dark_32x32": null, "favicon_dark_48x48": null, "favicon_dark_96x96": null, "favicon_dark_144x144": null, "favicon_dark_192x192": null, "favicon_dark_256x256": null, "favicon_dark_512x512": null}', '2025-01-31 10:41:57', '2025-03-06 15:26:34'),
('853f849e-a059-402d-bf8c-b81d93a7ecd2', 'default', NULL, 't', 2, 'lorem', '/lorem', NULL, 'pages', 'page', '{"seo": {"browser_title": null, "meta_description": null}, "hero": [], "title": "Lorem", "parent": "853f849e-a059-402d-bf8c-b81d93a7ecd3", "content": [{"id": "m6kmm934", "text": [{"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Magna fugiat ", "type": "text"}, {"text": "elit ullamco dolore", "type": "text", "marks": [{"type": "link", "attrs": {"rel": null, "href": "https://kraenk.de", "title": null, "target": null}}]}, {"text": " labore velit dolore ullamco aute nulla id ex sunt cupidatat proident. Voluptate cillum labore irure et nostrud est cupidatat commodo eu magna ullamco elit est. Minim amet reprehenderit eu esse incididunt in incididunt dolore velit non sunt et nostrud cupidatat fugiat. Eu laborum incididunt commodo fugiat duis commodo velit. Officia cillum fugiat pariatur exercitation aliquip culpa veniam culpa. Ut tempor sit quis et consequat nulla ea. Incididunt ullamco esse dolore commodo veniam id exercitation velit incididunt commodo ad nisi nulla velit. Adipisicing labore dolore exercitation occaecat do velit cillum.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Irure anim officia laboris id occaecat fugiat exercitation. Commodo ullamco occaecat tempor irure sint. In ea laborum dolore adipisicing quis ullamco ad consequat. Exercitation nostrud eu reprehenderit exercitation et amet duis exercitation sint minim. Ipsum officia ex cupidatat. Cillum ea veniam cupidatat nisi proident.", "type": "text"}]}], "type": "text", "buttons": [{"id": "mi3aexma", "link": "entry::74d50153-f84a-4921-b6b5-67f3101ac6df", "type": "button_set", "enabled": true, "link_text": "Dolor ipsum"}], "enabled": true, "subline": [{"text": "Occaecat esse voluptate elit eiusmod", "type": "text"}], "topline": [{"text": "Ad ex culpa nisi", "type": "text"}], "headline": [{"text": "Laborum commodo pariatur proident", "type": "text"}], "has_subline": true, "has_topline": true}, {"id": "m70r028w", "type": "text", "enabled": false, "headline": [{"text": "asdfadsf", "type": "text"}], "has_subline": false, "has_topline": false}, {"id": "m70r2qli", "file": "placeholders/desert-landscape-2.jpg", "type": "image", "caption": [{"type": "paragraph", "content": [{"text": "Enim consequat ut id irure elit fugiat mollit. ", "type": "text"}]}], "credits": [{"type": "paragraph", "content": [{"text": "© Amet Lorem", "type": "text"}]}], "enabled": true, "headline": [{"text": "Tempor officia occaecat", "type": "text"}], "force_ratio": false, "has_subline": false, "has_topline": false}, {"id": "m7126mzc", "file": "placeholders/desert-portrait-2.jpg", "type": "image", "ratio": "1:1", "caption": [{"type": "paragraph", "content": [{"text": "Adipisicing irure culpa ex mollit non", "type": "text"}]}], "credits": [{"type": "paragraph", "content": [{"text": "© Consequat Reprehenderit", "type": "text"}]}], "enabled": true, "force_ratio": true, "has_subline": false, "has_topline": false}, {"id": "m71y1q2p", "file": "placeholders/ocean-1.mp4", "type": "image", "enabled": true, "topline": [{"text": "Lorem", "type": "text"}], "headline": [{"text": "Adipisicing aute ad ipsum", "type": "text"}], "force_ratio": false, "has_subline": false, "has_topline": true}, {"id": "m71zeb84", "file": "placeholders/svg-1.svg", "type": "image", "enabled": true, "headline": [{"text": "Dolore aute fugiat", "type": "text"}], "force_ratio": false, "has_subline": false, "has_topline": false}, {"id": "m720i03w", "type": "video", "caption": [{"type": "paragraph", "content": [{"text": "Proident nisi", "type": "text"}]}], "enabled": true, "headline": [{"text": "Magna deserunt id anim nisi aliqua laboris consectetur", "type": "text"}], "embed_code": {"code": "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Mr_uHJPUlO8?si=cLRcR_eYxgh4GRj_\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>", "mode": "htmlmixed"}, "force_ratio": false, "has_subline": false, "has_topline": false}, {"id": "m721ipka", "type": "video", "credits": [{"type": "paragraph", "content": [{"text": "© Eu et anim", "type": "text"}]}], "enabled": true, "embed_code": {"code": "<iframe title=\"vimeo-player\" src=\"https://player.vimeo.com/video/92009539?h=2a6651b07c\" width=\"640\" height=\"360\" frameborder=\"0\"    allowfullscreen></iframe>\n<p>Test</p>", "mode": "htmlmixed"}, "force_ratio": false, "has_subline": false, "has_topline": false}, {"id": "mi36yiyd", "type": "slideshow", "ratio": "16:9", "slides": [{"id": "mi36yma8", "file": "placeholders/desert-portrait-2.jpg", "type": "slide", "enabled": true, "force_ratio": false}, {"id": "mi372qpr", "file": "placeholders/ocean-1.mp4", "type": "slide", "caption": [{"type": "paragraph", "content": [{"text": "Lorem Ipsum", "type": "text"}]}], "credits": [{"type": "paragraph", "content": [{"text": "Test credits", "type": "text"}]}], "enabled": true}, {"id": "mi377pdd", "file": "placeholders/svg-1.svg", "type": "slide", "enabled": true}], "enabled": true, "force_ratio": true, "has_subline": false, "has_topline": false}], "has_hero": false}', '2025-02-13 19:26:12', '2025-02-13 19:26:12'),
('853f849e-a059-402d-bf8c-b81d93a7ecd3', 'default', NULL, 't', 1, 'home', '/', NULL, 'pages', 'page', '{"hero": {"bg_medium": "placeholders/desert-landscape-1.jpg", "bg_medium_desktop": "placeholders/mountain-1.mp4"}, "title": "Home", "author": "a134c226-b5ed-442f-bc9d-538cbb00876c", "content": [{"id": "mi304n7n", "type": "cards", "cards": [{"id": "mi304r21", "file": "placeholders/desert-landscape-1.jpg", "text": [{"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Nulla eiusmod velit aliquip et laborum sit eiusmod deserunt cupidatat do veniam commodo. Laboris consequat sint ipsum excepteur pariatur exercitation. Veniam non commodo dolor eiusmod. Cupidatat proident cupidatat quis quis dolore ex occaecat. Commodo proident amet incididunt cillum est aliquip officia officia ut non duis exercitation.", "type": "text"}]}], "type": "card_set", "ratio": "4:3", "buttons": [{"id": "m5TMxqll", "link": "entry::74d50153-f84a-4921-b6b5-67f3101ac6df", "type": "button_set", "enabled": true, "rotation": "tiny_right", "link_text": "Nulla eiusmod", "decoration": "none", "button_text_size": "regular"}, {"id": "mi31q1dw", "link": "https://kraenk.de", "type": "button_set", "enabled": true, "link_text": "Commodo proident", "button_text_size": "regular"}], "enabled": true, "force_ratio": true}, {"id": "mi30tink", "file": "placeholders/mountain-1.mp4", "text": [{"type": "heading", "attrs": {"level": 2, "textAlign": "left"}, "content": [{"text": "Consectetur ", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "in labore consectetur laborum. Ex exercitation occaecat qui nulla eiusmod duis qui. In voluptate incididunt et anim proident. Magna in enim id magna adipisicing dolore amet labore veniam.", "type": "text"}]}], "type": "card_set", "ratio": "4:3", "enabled": true, "force_ratio": true}, {"id": "mi30xvvg", "file": "placeholders/svg-1.svg", "text": [{"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Eiusmod dolor aliquip culpa amet do exercitation velit dolore consequat consequat do tempor. Sit nostrud irure labore sint esse sit nisi mollit. Eu quis fugiat duis veniam labore eu velit duis id excepteur labore. Nulla deserunt eu officia voluptate do qui culpa veniam. Mollit et tempor Lorem qui.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Voluptate ullamco irure enim ullamco. Labore id laborum incididunt et voluptate velit magna nisi. Quis fugiat deserunt velit Lorem laboris aliquip. Excepteur nostrud ad eiusmod ea sunt reprehenderit proident nostrud in veniam aliquip. Sunt aliqua aute et exercitation mollit reprehenderit eu sit quis do dolore cillum eu. Elit exercitation eiusmod magna Lorem reprehenderit nulla ipsum incididunt labore non irure. Proident eu et elit eiusmod elit officia quis. Excepteur in magna fugiat id sunt officia magna veniam velit aute dolor.", "type": "text"}]}], "type": "card_set", "ratio": "4:3", "enabled": true, "force_ratio": true}], "enabled": true, "has_subline": false, "has_topline": false}], "has_hero": true, "template": "default"}', '2025-03-04 09:39:47', '2025-03-06 15:14:37'),
('da385716-8c2c-4b1f-81d9-363707b51974', 'default', NULL, 't', 6, 'bar', '/bar', NULL, 'pages', 'page', '{"seo": {"browser_title": null, "meta_description": null}, "title": "Anim magna aute", "has_hero": false, "updated_by": "a134c226-b5ed-442f-bc9d-538cbb00876c"}', '2025-02-07 14:36:49', '2025-02-07 14:36:49'),
('e7d49817-d266-4fb1-a169-a55c30864a40', 'default', NULL, 't', 7, 'impressum', '/impressum', NULL, 'pages', 'page', '{"hero": [], "title": "Impressum", "parent": "853f849e-a059-402d-bf8c-b81d93a7ecd3", "content": [{"id": "mi3bj9k4", "text": [{"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Do non excepteur minim aliquip eu cillum adipisicing magna. Incididunt occaecat adipisicing aliqua do in non elit non reprehenderit enim dolor aute minim. Elit Lorem do sit adipisicing elit ex quis sunt culpa cillum ex occaecat. Nisi velit aute eu sit minim veniam ad in id sit anim. Lorem anim exercitation laborum officia ea Lorem. Enim consectetur ex fugiat reprehenderit dolore consequat. Sint est quis anim do pariatur incididunt ullamco.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Occaecat fugiat minim incididunt exercitation aute amet cupidatat. Ea laborum consequat anim ad labore reprehenderit ea nulla laborum consectetur commodo laboris. Esse aute consectetur labore enim Lorem et laboris sit adipisicing elit do cupidatat proident labore. Tempor nisi est est dolor officia fugiat quis laborum consectetur enim commodo nulla. Anim aliquip amet qui eu anim elit proident. Consectetur dolor fugiat non nulla. Excepteur esse laboris voluptate qui. Non amet sunt consectetur commodo minim proident cillum exercitation est.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Minim veniam laborum nostrud ad est non deserunt cillum excepteur minim aliqua pariatur. Anim ipsum et incididunt amet aliqua exercitation dolore irure. Consequat non reprehenderit quis nisi fugiat sint quis pariatur. Consequat cupidatat tempor laborum duis eiusmod incididunt ullamco. Et dolor incididunt deserunt anim nostrud anim cillum aliquip et elit do ex adipisicing Lorem esse.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Minim culpa enim magna cillum et Lorem dolore aliquip amet eu ad. Pariatur voluptate sint nisi nostrud. Laboris culpa minim adipisicing elit irure esse est. Nisi qui sint qui anim mollit in est veniam et minim mollit magna quis. Sit tempor nostrud sit cillum qui cillum proident commodo cupidatat pariatur dolor. Fugiat dolore aute qui duis reprehenderit adipisicing. Est laborum sit consectetur duis mollit esse ullamco voluptate aliqua occaecat deserunt id.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Sunt nostrud commodo occaecat quis nostrud. Ullamco non deserunt non. Aute esse exercitation officia. Officia velit quis duis nulla do esse quis magna. Occaecat laboris dolore veniam est qui ullamco ut sunt eu voluptate. Anim exercitation veniam ex occaecat deserunt ex Lorem in occaecat irure sint qui anim nisi. In non duis sunt.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Do elit tempor non fugiat magna in reprehenderit occaecat elit eiusmod quis in commodo ea. Ut veniam adipisicing ipsum consectetur officia esse consequat exercitation. Dolor nostrud enim est exercitation sunt proident laboris deserunt. Aute ipsum in do consectetur occaecat sunt laborum incididunt amet exercitation consequat velit ullamco. Aliqua magna excepteur labore voluptate. Mollit eu nostrud nostrud veniam. Consequat in minim nulla officia voluptate eu aliquip. Tempor dolor proident dolore.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Et anim sit qui est aliquip quis anim culpa. Ullamco est reprehenderit fugiat id. Laboris elit est deserunt aliquip magna labore magna consectetur culpa dolor sint. Pariatur ex nostrud irure et magna deserunt minim et aliqua duis dolor. Laboris ex irure amet incididunt Lorem non ut amet laborum ut ea nostrud mollit. Minim nisi commodo id qui voluptate in aliquip sint anim mollit incididunt mollit esse sit labore. Exercitation deserunt aliquip eiusmod proident excepteur irure aliqua.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Consequat aute nostrud veniam est cillum duis ut occaecat aliquip in laboris ea duis nisi officia. Eiusmod ex cupidatat consequat cillum dolore pariatur. Quis id quis proident esse qui cupidatat est officia fugiat. Ullamco voluptate laboris est qui elit. Id incididunt do do aliqua pariatur duis consequat incididunt. Nisi id minim aliquip sunt deserunt. Minim quis proident velit exercitation voluptate.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Irure nisi ullamco non qui id enim officia non mollit reprehenderit mollit dolore. Officia eu ad id occaecat esse in magna et ut proident reprehenderit mollit. Esse elit incididunt ea ex consequat culpa exercitation tempor qui in. Commodo quis ullamco deserunt adipisicing excepteur amet aute ullamco ad culpa reprehenderit. Sint nostrud quis do dolor mollit laborum exercitation dolor officia excepteur id ipsum amet do. Aliquip excepteur aute pariatur non.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Qui irure qui amet dolore labore. Sint voluptate veniam minim fugiat veniam exercitation. Ut proident anim nostrud eu pariatur velit eu occaecat nostrud sit minim labore. Dolor nostrud pariatur deserunt ex est nulla non mollit quis esse aliquip. Cillum cupidatat laborum non in laboris anim magna. Tempor adipisicing non elit.", "type": "text"}]}], "type": "text", "enabled": true, "has_subline": false, "has_topline": false}], "has_hero": false}', '2025-02-07 14:36:49', '2025-02-07 14:36:49'),
('186e1ce5-b4af-4a52-9c9b-d36a74376a2a', 'default', NULL, 't', 8, 'datenschutzerklaerung', '/datenschutzerklaerung', NULL, 'pages', 'page', '{"hero": [], "title": "Datenschutzerklärung", "parent": "853f849e-a059-402d-bf8c-b81d93a7ecd3", "content": [{"id": "mi3bjvtp", "text": [{"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Cillum consectetur sint quis. Excepteur non aliquip occaecat ex. Pariatur exercitation irure tempor aute et cupidatat proident exercitation deserunt. Incididunt reprehenderit consequat in ex ullamco. Pariatur proident laboris amet fugiat exercitation do laboris officia pariatur consectetur consectetur deserunt sit duis. Veniam magna aliquip ullamco nulla et incididunt amet officia ullamco sit commodo.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Do tempor cillum quis duis eu. Minim voluptate officia culpa amet eiusmod nisi deserunt. Do occaecat labore est. Veniam cillum aute occaecat nulla. Exercitation laborum anim consectetur tempor consectetur culpa cillum duis adipisicing enim irure.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Anim officia ipsum consequat incididunt velit. Mollit consectetur nostrud eiusmod et excepteur occaecat irure ut sit deserunt exercitation labore est ipsum. Non tempor excepteur velit deserunt eu ut ut aliquip reprehenderit proident. Tempor nulla occaecat Lorem ad magna esse.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Cillum excepteur magna sunt Lorem ad consectetur cupidatat. Esse consectetur proident labore velit culpa officia veniam sunt labore aliqua dolore. Duis non duis nulla eiusmod aliqua velit est dolore laborum qui. Velit do consequat culpa in minim ex commodo commodo nisi ea.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Ea amet Lorem pariatur id nulla nostrud non deserunt qui enim. Eu enim aliqua ipsum consequat ex eu labore ullamco aute et nostrud. Incididunt tempor cupidatat pariatur nostrud cupidatat ea labore reprehenderit Lorem cupidatat excepteur. Laboris laborum mollit adipisicing. Incididunt consequat sunt in dolor laboris. Ullamco enim consequat qui incididunt cupidatat nostrud enim reprehenderit elit. Magna eiusmod ut qui dolore ea quis est irure nostrud fugiat nulla dolor.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Nisi veniam culpa cupidatat quis consectetur fugiat commodo officia magna ad ipsum. Sit dolore nisi qui laborum ipsum dolore elit in. Officia eiusmod cupidatat amet qui eu dolor do occaecat officia adipisicing non est non aliqua incididunt. Officia enim Lorem esse veniam ea veniam id irure exercitation. Lorem veniam non anim magna nostrud nulla sint nulla. Sit amet minim Lorem. Reprehenderit aliquip consectetur id adipisicing ea ullamco sit cillum occaecat officia reprehenderit eu sint.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Esse sint commodo dolor proident eu ipsum mollit enim pariatur. Laboris labore occaecat magna in pariatur cupidatat sint id consectetur ea laborum laborum. Ea officia nostrud ad fugiat ut aliquip. Quis cupidatat dolore nisi est velit eiusmod veniam minim voluptate quis ullamco fugiat. Veniam ea id elit aliquip tempor voluptate. Proident veniam nisi enim. Occaecat deserunt in incididunt qui in nostrud et eu. Cupidatat dolor officia anim incididunt nostrud ipsum tempor commodo.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Fugiat elit labore proident deserunt eiusmod dolore dolore culpa Lorem et aliquip ea ea officia minim. Non tempor exercitation culpa est eiusmod in id id aliquip magna anim id. Quis labore eu pariatur pariatur labore minim officia voluptate sint exercitation pariatur non et ad do. Est ipsum dolor ex incididunt. Aute consectetur Lorem eu. Cupidatat ad exercitation quis velit commodo eu quis eu sint sit ad dolore tempor. Ut irure deserunt proident magna excepteur culpa officia nisi mollit amet voluptate exercitation non id nostrud.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Lorem anim culpa incididunt amet deserunt enim. Laboris sit quis mollit dolore anim quis in eiusmod excepteur consectetur aliqua veniam elit amet. Commodo sint ullamco ullamco sint exercitation. Quis ex ipsum quis mollit ipsum proident id est sunt et laboris ipsum eiusmod veniam pariatur. Cillum consectetur est nostrud ea sit. Proident elit velit est commodo consectetur reprehenderit ullamco adipisicing anim.", "type": "text"}]}], "type": "text", "enabled": true, "has_subline": false, "has_topline": false}], "has_hero": false}', '2025-02-07 14:36:49', '2025-02-07 14:36:49'),
('574352c6-26d2-4ee7-ad5c-843f35a40077', 'default', NULL, 't', 9, 'agb', '/agb', NULL, 'pages', 'page', '{"hero": [], "title": "AGB", "parent": "853f849e-a059-402d-bf8c-b81d93a7ecd3", "content": [{"id": "mi3bkduh", "text": [{"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Elit commodo ullamco elit proident. Fugiat incididunt voluptate do occaecat enim eiusmod ad laborum sint id est. Mollit voluptate dolore ullamco ad do Lorem Lorem anim nulla consequat. Voluptate elit magna consequat dolore. Tempor nulla sint sunt nostrud aliqua et fugiat eiusmod officia non. Sunt in minim ad eiusmod enim sit Lorem est nulla tempor Lorem est anim veniam. Exercitation adipisicing adipisicing aliqua nisi.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Sunt pariatur voluptate aliqua nulla aute. Occaecat occaecat incididunt voluptate aliquip ad officia do proident nisi. Aute cupidatat et ipsum ipsum nulla anim occaecat laboris quis ut ex voluptate. Irure nostrud adipisicing adipisicing anim dolore id.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Irure nostrud deserunt occaecat minim mollit labore deserunt tempor excepteur quis nisi ut magna. Pariatur culpa minim occaecat ea laborum laboris adipisicing. Qui elit duis quis sunt laborum do aliqua culpa anim veniam minim dolor esse. Nulla excepteur et consectetur proident aliquip laboris.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Duis reprehenderit non elit nostrud nisi ex aliqua dolor eu officia deserunt eiusmod. Elit eiusmod est Lorem laborum consequat. Adipisicing voluptate cillum magna reprehenderit sit laboris occaecat dolor et excepteur. Amet eiusmod minim sint quis eu velit in est cillum exercitation mollit magna. Tempor esse Lorem qui anim occaecat nulla exercitation ut quis ipsum.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Labore laboris aliquip exercitation reprehenderit qui tempor. Quis ad reprehenderit laboris commodo eu aliquip reprehenderit. Reprehenderit non nulla velit dolor. Ad exercitation nulla minim aliquip quis adipisicing pariatur esse consequat. Qui dolore excepteur exercitation irure.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Elit veniam eu deserunt laboris ea voluptate dolor enim. Occaecat laboris enim amet eiusmod commodo quis minim magna id eu laboris. Irure nisi incididunt quis cillum ullamco cillum ad id nostrud magna veniam. Deserunt commodo proident magna mollit tempor dolore irure sit ipsum eu consectetur. Consectetur eu sint Lorem tempor. Amet nulla aliquip deserunt. Est do reprehenderit voluptate. Ut proident nulla fugiat esse culpa in deserunt adipisicing.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Esse laborum minim labore quis sint non ex Lorem ad aute ullamco aliquip veniam et irure. Magna Lorem commodo deserunt dolor reprehenderit consectetur. Ut do dolore cillum veniam deserunt nulla culpa incididunt veniam dolore. Mollit dolore eiusmod cupidatat cillum esse laboris et excepteur labore. Consequat ut id amet voluptate labore sit dolore aliqua amet consectetur laborum eu labore ipsum.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Ad et ut do cillum consequat ex velit fugiat dolor dolore dolore ut. Occaecat est ex voluptate ex fugiat labore aliquip irure id ipsum occaecat aliquip est labore. Nostrud cupidatat officia dolore est do consequat. Ut irure consequat qui Lorem et sunt. Consequat aliquip ut laborum elit occaecat laborum Lorem tempor. Non cillum dolore nulla.", "type": "text"}]}, {"type": "paragraph", "attrs": {"textAlign": "left"}, "content": [{"text": "Laborum quis veniam consequat laborum do amet ipsum velit dolor pariatur magna elit sint. Occaecat incididunt enim occaecat sit ullamco sint. Incididunt amet quis qui sint occaecat nulla sunt ea nulla cupidatat eu in do. Do sint aliqua incididunt veniam labore esse. Excepteur nulla aliqua proident. Sint sit exercitation non deserunt amet anim amet voluptate sunt esse sunt culpa do aliquip id. Velit dolore aliqua cillum in non pariatur nisi nisi aute velit reprehenderit qui proident enim deserunt. Nostrud aliquip magna minim aute amet ex fugiat sit do.", "type": "text"}]}], "type": "text", "enabled": true, "has_subline": false, "has_topline": false}], "has_hero": false}', '2025-02-07 14:36:49', '2025-02-07 14:36:49');

INSERT INTO "public"."global_set_variables" ("id", "handle", "locale", "origin", "data", "created_at", "updated_at") VALUES
(1, 'settings', 'default', NULL, '{"dark_mode": null, "main_logo": "logos/logo-dummy.png", "light_mode": null, "browser_title": "Sit officia aliquip deserunt", "favicon_16x16": null, "favicon_32x32": null, "favicon_48x48": null, "favicon_96x96": "favicons/icon-96.png", "website_title": "¯\\_(ツ)_/¯", "main_logo_dark": "logos/logo-dummy-dark.png", "favicon_144x144": null, "favicon_192x192": null, "favicon_256x256": null, "favicon_512x512": "favicons/icon-512.png", "favicons_section": null, "meta_description": "Qui nisi consequat consequat tempor reprehenderit incididunt aute consectetur ipsum ut minim in ut.", "favicon_dark_16x16": null, "favicon_dark_32x32": null, "favicon_dark_48x48": null, "favicon_dark_96x96": "favicons/icon-96-dark.png", "favicon_dark_144x144": null, "favicon_dark_192x192": null, "favicon_dark_256x256": null, "favicon_dark_512x512": "favicons/icon-512-dark.png", "social_media_links": [{"id": "mi3deimv", "link": "www.facebook.com/kraenk.visuell", "type": "social_media_link", "enabled": true}, {"id": "mi3dexww", "link": "https://www.instagram.com/kraenkvisuell", "type": "social_media_link", "enabled": true}]}', '2025-03-04 09:49:43', '2025-03-09 11:08:43'),
(2, 'settings', 'en', 'default', '{"dark_mode": null, "main_logo": "logos/logo-dummy.png", "light_mode": null, "browser_title": "Sit officia aliquip deserunt", "favicon_16x16": null, "favicon_32x32": null, "favicon_48x48": null, "favicon_96x96": "favicons/icon-96.png", "website_title": "¯\\_(ツ)_/¯", "main_logo_dark": "logos/logo-dummy-dark.png", "favicon_144x144": null, "favicon_192x192": null, "favicon_256x256": null, "favicon_512x512": "favicons/icon-512.png", "favicons_section": null, "meta_description": "Qui nisi consequat consequat tempor reprehenderit incididunt aute consectetur ipsum ut minim in ut.", "favicon_dark_16x16": null, "favicon_dark_32x32": null, "favicon_dark_48x48": null, "favicon_dark_96x96": "favicons/icon-96-dark.png", "favicon_dark_144x144": null, "favicon_dark_192x192": null, "favicon_dark_256x256": null, "favicon_dark_512x512": "favicons/icon-512-dark.png"}', '2025-03-04 09:49:43', '2025-03-09 11:08:43');

INSERT INTO "public"."global_sets" ("id", "handle", "title", "settings", "created_at", "updated_at") VALUES
(1, 'settings', 'Einstellungen', '[]', '2025-02-14 16:30:14', '2025-02-14 16:30:14');

INSERT INTO "public"."migrations" ("id", "migration", "batch") VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_03_07_100000_create_collections_table', 1),
(5, '2024_03_07_100000_create_entries_table_with_string_ids', 1),
(6, '2024_03_07_100000_create_navigation_trees_table', 1),
(7, '2024_03_07_100000_create_forms_table', 2),
(8, '2024_03_07_100000_create_form_submissions_table', 3),
(9, '2024_05_15_100000_modify_form_submissions_id', 3),
(10, '2024_03_07_100000_create_globals_table', 4),
(11, '2024_03_07_100000_create_global_variables_table', 5),
(12, '2024_03_07_100000_create_navigations_table', 6),
(13, '2024_03_07_100000_create_taxonomies_table', 7),
(14, '2024_03_07_100000_create_terms_table', 8),
(15, '2024_03_07_100000_create_tokens_table', 9),
(16, '2025_03_09_125555_statamic_auth_tables', 10);

INSERT INTO "public"."navigations" ("id", "handle", "title", "settings", "created_at", "updated_at") VALUES
(1, 'main_navigation', 'Hauptnavigation', '{"max_depth": 2, "collections": ["pages"], "expects_root": false, "select_across_sites": false}', '2025-01-31 10:42:54', '2025-01-31 10:42:54'),
(2, 'secondary_navigation', 'Sekundärnavigation', '{"max_depth": 1, "collections": ["pages"], "expects_root": false, "select_across_sites": false}', '2025-01-31 10:42:54', '2025-01-31 10:42:54');

INSERT INTO "public"."trees" ("id", "handle", "type", "locale", "tree", "settings", "created_at", "updated_at") VALUES
(1, 'main_navigation', 'navigation', 'default', '[{"id": "b30649bc-fb14-4c9c-a2b4-eb3a405e0b61", "entry": "853f849e-a059-402d-bf8c-b81d93a7ecd2"}, {"id": "d1164b21-6e7c-4c7d-b4c6-303b555f3fb6", "title": "Ipsum", "children": [{"id": "0477bb90-d16f-43e3-97b0-18087a632229", "entry": "72846eb4-114d-4e90-b48b-609d10188b7e"}, {"id": "ff05df71-8621-4cd1-9054-9aeaacbbe14f", "entry": "da385716-8c2c-4b1f-81d9-363707b51974"}, {"id": "b77002c5-82b8-4802-a88a-bbf70ec79f83", "entry": "4a020d65-c423-446a-b3c1-ff486f1e68c3"}]}, {"id": "a50c933c-07da-4e2e-916a-55f00fc5e280", "entry": "74d50153-f84a-4921-b6b5-67f3101ac6df"}]', '[]', '2025-02-07 15:09:45', '2025-02-07 15:09:45'),
(2, 'pages', 'collection', 'default', '[{"entry": "853f849e-a059-402d-bf8c-b81d93a7ecd3"}, {"entry": "853f849e-a059-402d-bf8c-b81d93a7ecd2"}, {"entry": "74d50153-f84a-4921-b6b5-67f3101ac6df"}, {"entry": "72846eb4-114d-4e90-b48b-609d10188b7e"}, {"entry": "4a020d65-c423-446a-b3c1-ff486f1e68c3"}, {"entry": "da385716-8c2c-4b1f-81d9-363707b51974"}]', '[]', '2025-02-07 15:09:45', '2025-02-07 15:09:45'),
(3, 'secondary_navigation', 'navigation', 'default', '[{"id": "6df8fbde-939a-41e5-b88a-836879380647", "entry": "e7d49817-d266-4fb1-a169-a55c30864a40"}, {"id": "7a7ae6c5-4691-4c4a-8681-866029aefa5b", "entry": "186e1ce5-b4af-4a52-9c9b-d36a74376a2a"}, {"id": "c6514811-0a53-4a43-8b2c-e157aed742c9", "entry": "574352c6-26d2-4ee7-ad5c-843f35a40077"}]', '[]', '2025-02-07 15:09:45', '2025-02-07 15:09:45');

INSERT INTO "public"."users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "super", "avatar", "preferences", "last_login") VALUES
(2, 'Basti', 'hilger@kraenk.de', NULL, '$2y$12$lF8JSMqRto0koUZtK5.eiuqXEPhUF1FedetjMVMrzE8GiCJ/XG6c6', NULL, '2025-03-09 13:05:15', '2025-03-09 13:05:15', 't', NULL, NULL, NULL);

INSERT INTO "public"."users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "super", "avatar", "preferences", "last_login") VALUES
(3, 'Tobi', 'bender@kraenk.de', NULL, '$2y$12$bZUiMtfWnQSmbsHZoeeWnukHBL2.34TVpmrn5t2hDjcwhgraCnm7e', NULL, '2025-03-09 13:05:15', '2025-03-09 13:05:15', 't', NULL, NULL, NULL);

INSERT INTO "public"."users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "super", "avatar", "preferences", "last_login") VALUES
(4, 'Stephan', 'trischler@kraenk.de', NULL, '$2y$12$gbaB8qWnfdXpiw02MHOhju0r0M4g4DUF/sVNC.Np0aUdiNz5pT8ue', NULL, '2025-03-09 13:05:15', '2025-03-09 13:05:15', 't', NULL, NULL, NULL);

INSERT INTO "public"."users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "super", "avatar", "preferences", "last_login") VALUES
(5, 'Didem', 'didem@kraenk.de', NULL, '$2y$12$qSyYDwn7UwtgOEb.R2zyiOlC/ztTH9QKMH5YCYAy7P7j9s9zqyxEW', NULL, '2025-03-09 13:05:15', '2025-03-09 13:05:15', 't', NULL, NULL, NULL);

INSERT INTO "public"."users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "super", "avatar", "preferences", "last_login") VALUES
(6, 'Wiebke', 'wiebke@kraenk.de', NULL, '$2y$12$RJ/8IiXgmkiMMLdwXh8FE.pA5CpLDasWbx9Ga86Yt1Sfb29S75Lee', NULL, '2025-03-09 13:05:15', '2025-03-09 13:05:15', 't', NULL, NULL, NULL);

INSERT INTO "public"."sites" ("id", "handle", "name", "order", "url", "locale", "lang", "attributes", "created_at", "updated_at") VALUES
(1, 'default', 'Deutsch', 1, '/', 'de_DE', 'de', '[]', '2025-03-09 13:05:15', '2025-03-09 13:05:15'),
(2, 'en', 'English', 2, '/en', 'en_US', 'en', '[]', '2025-03-09 13:05:15', '2025-03-09 13:05:15');


-- Indices
CREATE UNIQUE INDEX collections_handle_unique ON public.collections USING btree (handle);

-- Indices
CREATE INDEX entries_site_index ON public.entries USING btree (site);
CREATE INDEX entries_origin_id_index ON public.entries USING btree (origin_id);
CREATE INDEX entries_uri_index ON public.entries USING btree (uri);
CREATE INDEX entries_order_index ON public.entries USING btree ("order");
CREATE INDEX entries_collection_index ON public.entries USING btree (collection);
CREATE INDEX entries_blueprint_index ON public.entries USING btree (blueprint);


-- Indices
CREATE UNIQUE INDEX failed_jobs_uuid_unique ON public.failed_jobs USING btree (uuid);


-- Indices
CREATE UNIQUE INDEX form_submissions_form_created_at_unique ON public.form_submissions USING btree (form, created_at);
CREATE INDEX form_submissions_form_index ON public.form_submissions USING btree (form);
CREATE UNIQUE INDEX form_submissions_id_unique ON public.form_submissions USING btree (id);


-- Indices
CREATE UNIQUE INDEX forms_handle_unique ON public.forms USING btree (handle);


-- Indices
CREATE INDEX global_set_variables_handle_index ON public.global_set_variables USING btree (handle);


-- Indices
CREATE UNIQUE INDEX global_sets_handle_unique ON public.global_sets USING btree (handle);


-- Indices
CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


-- Indices
CREATE UNIQUE INDEX navigations_handle_unique ON public.navigations USING btree (handle);


-- Indices
CREATE INDEX password_activation_tokens_email_index ON public.password_activation_tokens USING btree (email);


-- Indices
CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);
CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


-- Indices
CREATE UNIQUE INDEX taxonomies_handle_unique ON public.taxonomies USING btree (handle);


-- Indices
CREATE UNIQUE INDEX taxonomy_terms_slug_taxonomy_site_unique ON public.taxonomy_terms USING btree (slug, taxonomy, site);
CREATE INDEX taxonomy_terms_site_index ON public.taxonomy_terms USING btree (site);
CREATE INDEX taxonomy_terms_uri_index ON public.taxonomy_terms USING btree (uri);
CREATE INDEX taxonomy_terms_taxonomy_index ON public.taxonomy_terms USING btree (taxonomy);


-- Indices
CREATE UNIQUE INDEX tokens_token_unique ON public.tokens USING btree (token);


-- Indices
CREATE UNIQUE INDEX trees_handle_type_locale_unique ON public.trees USING btree (handle, type, locale);
CREATE INDEX trees_type_index ON public.trees USING btree (type);
CREATE INDEX trees_locale_index ON public.trees USING btree (locale);


-- Indices
CREATE UNIQUE INDEX users_email_unique ON public.users USING btree (email);


-- Indices
CREATE UNIQUE INDEX sites_handle_unique ON public.sites USING btree (handle);

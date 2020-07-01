-- TABLE
CREATE TABLE "posts" ("id" integer,"content" text NOT NULL,"authuser" integer NOT NULL,"created" datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, "ip_address" text, "user_agent" text, PRIMARY KEY (id));
CREATE TABLE "posts_hidden" ("id" integer,"post_id" integer,"created" datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, "ip_address" text, "user_agent" text, PRIMARY KEY (id));
CREATE TABLE "users" ("id" integer, "authuser" integer, "password" text, "created" datetime, "ip_address" text, "user_agent" text, PRIMARY KEY (id));

-- INDEX

-- TRIGGER

-- VIEW

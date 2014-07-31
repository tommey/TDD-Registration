CREATE TABLE user (
  id INTEGER PRIMARY KEY,
  email TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  type TEXT NOT NULL CHECK(type = 'local' OR type = 'facebook' OR type = 'google')
);

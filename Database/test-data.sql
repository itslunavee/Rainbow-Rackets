USE rainbow_rackets;

-- Insert test admin user
INSERT INTO users (name, email, password, message, gender, status)
VALUES (
  'Admin', 
  'admin@rainbowrackets.com', 
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Hash for "password"
  'Initial admin account', 
  'Trans Woman', 
  'admin'
);

-- Insert test event
INSERT INTO events (event_date, event_type, location, description, created_by)
VALUES (
  '2024-06-15', 
  'Doubles Tournament', 
  'Central Park Tennis Courts', 
  'LGBTQ+ friendly doubles match!', 
  1  -- Assumes admin has user_id = 1
);

-- Insert test points
INSERT INTO points (user_id, event_id, points)
VALUES (1, 1, 10);  -- Give admin 10 points for the event
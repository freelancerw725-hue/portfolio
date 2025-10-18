-- Sample data insertion for projects table
INSERT INTO projects (title, description, image, status, created_at, client_id) VALUES
('Project Alpha', 'Description for Project Alpha', 'project_alpha.jpg', 'pending', NOW(), 1),
('Project Beta', 'Description for Project Beta', 'project_beta.jpg', 'in_progress', NOW(), 1),
('Project Gamma', 'Description for Project Gamma', 'project_gamma.jpg', 'completed', NOW(), 1);

-- Sample data insertion for contact_messages table
INSERT INTO contact_messages (name, email, message, created_at) VALUES
('John Doe', 'john@example.com', 'Hello, I am interested in your services.', NOW()),
('Jane Smith', 'jane@example.com', 'Please contact me regarding a project.', NOW());

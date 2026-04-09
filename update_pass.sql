UPDATE field_assist.users 
SET password_hash = '$2y$10$npMtOAmvvtNNgyfAhRbbX.fnkZ3yK55astSsODnOYeegkYP2vpXum' 
WHERE username IN ('admin', 'agent_john');

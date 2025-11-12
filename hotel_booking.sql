
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  price_per_night DECIMAL(10,2) NOT NULL,
  max_guests INT NOT NULL,
  image_url VARCHAR(500) NOT NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  room_id INT NOT NULL,
  check_in DATE NOT NULL,
  check_out DATE NOT NULL,
  guests INT NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  created_at DATETIME NOT NULL,
  CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_room FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
) ENGINE=InnoDB;
INSERT INTO rooms(title,description,price_per_night,max_guests,image_url) VALUES

('Oceanview Suite','Spacious suite with panoramic ocean views, private balcony, and premium bedding.',280,3,'https://images.unsplash.com/photo-1560448205-4d9b3e6bb6db?q=80&w=1400&auto=format&fit=crop'),
('Urban King','Modern room in the heart of the city with floor-to-ceiling windows and king bed.',180,2,'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?q=80&w=1400&auto=format&fit=crop'),
('Mountain Retreat','Warm alpine design with fireplace, reading nook, and forest views.',220,3,'https://plus.unsplash.com/premium_photo-1676968002767-1f6a09891350?q=80&w=1400&auto=format&fit=crop'),
('Poolside Deluxe','Direct access to pool deck, outdoor seating, and lounge chairs.',240,2,'https://images.unsplash.com/photo-1501183638710-841dd1904471?q=80&w=1400&auto=format&fit=crop'),
('Family Suite','Two-bedroom suite ideal for families, kitchenette and dining area.',300,5,'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=1400&auto=format&fit=crop'),
('Boutique Loft','Industrial-chic loft with mezzanine sleeping area and designer furnishings.',210,2,'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?q=80&w=1400&auto=format&fit=crop');
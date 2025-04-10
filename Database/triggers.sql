-- Trigger: Auto-update total_points when points are added
DELIMITER $$
CREATE TRIGGER update_total_points
AFTER INSERT ON points
FOR EACH ROW
BEGIN
  UPDATE users 
  SET total_points = (
    SELECT SUM(points) 
    FROM points 
    WHERE user_id = NEW.user_id
  )
  WHERE user_id = NEW.user_id;
END$$
DELIMITER ;
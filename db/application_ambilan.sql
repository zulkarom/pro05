
CREATE TABLE `application_ambilan` (
  `id` int(11) NOT NULL,
  `ambilan_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `application_ambilan` (`id`, `ambilan_name`) VALUES
(1, 'S-S1'),
(2, 'F-S2'),
(3, 'F-S3'),
(4, 'S-S2');

ALTER TABLE `application_ambilan`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `application_ambilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

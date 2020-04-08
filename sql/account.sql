CREATE TABLE IF NOT EXISTS `Account` (
`ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_number` varchar(12) NOT NULL,
  `Account_type` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account`
--
ALTER TABLE `Account`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Account`
--
ALTER TABLE `Account`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

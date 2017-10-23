/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2017-09-14 14:33:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mood
-- ----------------------------
DROP TABLE IF EXISTS `mood`;
CREATE TABLE `mood` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mood0` tinyint(255) DEFAULT '0',
  `mood1` tinyint(255) DEFAULT '1',
  `mood2` tinyint(255) DEFAULT '2',
  `mood3` tinyint(255) DEFAULT '3',
  `mood4` tinyint(255) DEFAULT '4',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mood
-- ----------------------------
INSERT INTO `mood` VALUES ('1', '8', '10', '8', '31', '4');
INSERT INTO `mood` VALUES ('2', '2', '0', '0', '0', '0');

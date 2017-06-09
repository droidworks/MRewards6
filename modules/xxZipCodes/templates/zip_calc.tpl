<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--
    Getting All ZIP Codes In A Given Radius From A Known Point / ZIP Code Via PHP And MySQL
    Copyright (C) 2009 Doug Vanderweide
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Getting All ZIP Codes In A Given Radius From A Known Point / ZIP Code Via PHP And MySQL</title>
</head>
<body>
<h1>
    Getting All ZIP Codes In A Given Radius From A Known Point / ZIP Code Via PHP And MySQL
</h1>
<form action="index1.php" method="post" name="zipform">
    <label>Enter your ZIP Code: <input type="text" name="zipcode" size="6" maxlength="5" value="<?php echo $_POST['zipcode']; ?>" /></label>
    <br />
    <label>Select a distance in miles from this point:</label>
    <select name="distance">
        <option<?php if($_POST['distance'] == "5") { echo " selected=\"selected\""; } ?>>5</option>
        <option<?php if($_POST['distance'] == "10") { echo " selected=\"selected\""; } ?>>10</option>
        <option<?php if($_POST['distance'] == "25") { echo " selected=\"selected\""; } ?>>25</option>
        <option<?php if($_POST['distance'] == "50") { echo " selected=\"selected\""; } ?>>50</option>
        <option<?php if($_POST['distance'] == "100") { echo " selected=\"selected\""; } ?>>100</option>
    </select>
    <br />
    <input type="submit" name="submit" value="Submit" />
</form>
<br />
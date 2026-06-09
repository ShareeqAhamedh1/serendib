<?php
require 'conn.php';
require 'helpers.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_marks_report.xls");

include 'fetch_student_marks_report.php';

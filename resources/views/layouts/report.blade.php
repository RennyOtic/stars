<style>
* {
	font-family: helvetica;
	box-sizing: border-box;
}
div {
	font-size: 12pt;
}
.wrapper {
	width: 700px;
	margin: 0 auto;
}
.row {
	width: 100%;
	margin-bottom: 15px;
	clear: both;
	display: table;
	content: " ";
}
.pull-left {float: left; }
.pull-right {float: right; }
.text-center {text-align: center; }
.text-left {text-align: left; }
.text-right {text-align: right; }
table {
	width: 100%;
	border: 1px solid #ddd;
	width: 100%;
	max-width: 100%;
	margin-bottom: 20px;	
	background-color: transparent;
	border-spacing: 0;
	border-collapse: collapse;
}
tr {
	display: table-row;
	vertical-align: inherit;
	border-color: inherit;
}
th {
	font-weight: bold;
	background-color: #eee;
}
th, td {
	border-top: 0;
	border-bottom-width: 2px;
	border: 1px solid #ddd;
	padding: 5px;
	vertical-align: bottom;
	line-height: 1.42857143;
	text-align: left;
	display: table-cell;
}
.page-break {
    page-break-after: always;
}
h1, h2, h3, h4, h5, h6 {
	margin: 0;
	padding: 0;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<div class="wrapper">
		@yield('content')
	</div>
</body>
</html>
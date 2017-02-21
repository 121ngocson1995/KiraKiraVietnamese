<!DOCTYPE html>
<html>
<head>
	<title>Dummy page</title>

	<style>
		td {
			padding: 1em;
		}
	</style>
</head>
<body>
	{{-- Ví dụ import dữ liệu từ json và hiển thị trên view --}}

	<h1>Dummy Page</h1>

	<hr>

	<h3>Print out dummy array:</h3>

	@php
		var_dump(json_encode($dummy));
	@endphp

	<br>

	<h3>Print out dummy element inside the object:</h3>

	<table>
		<tr>
			<td>- $dummy[0]->dummy1 <i>gives:</i></td>
			<td>{{ $dummy[0]->dummy1 }}</td>
		</tr>
		<tr>
			<td>- $dummy[1]->dummy3->nestedDummy1 <i>gives:</i></td>
			<td>{{ $dummy[1]->dummy3->nestedDummy1 }}</td>
		</tr>
		<tr>
			<td>- $dummy[1]->dummy4[0]->arrayNested3 <i>gives:</i></td>
			<td>{{ $dummy[1]->dummy4[0]->arrayNested3 }}</td>
		</tr>
	</table>
</body>
</html>
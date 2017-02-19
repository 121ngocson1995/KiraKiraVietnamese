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
	<h1>Dummy Page</h1>

	<hr>

	<h3>Print out dummy object:</h3>

	<?php 
		var_dump(json_encode($dummy));
	 ?>

	<br>

	<h3>Print out dummy element inside the object:</h3>

	<table>
		<tr>
			<td>- $dummy->dummy1 <i>gives:</i></td>
			<td><?php echo e($dummy->dummy1); ?></td>
		</tr>
		<tr>
			<td>- $dummy->dummy2->nestedDummy2[0] <i>gives:</i></td>
			<td><?php echo e($dummy->dummy2->nestedDummy2[0]); ?></td>
		</tr>
		<tr>
			<td>- $dummy->dummy3[1]->arrayNested4 <i>gives:</i></td>
			<td><?php echo e($dummy->dummy3[1]->arrayNested4); ?></td>
		</tr>
	</table>
</body>
</html>
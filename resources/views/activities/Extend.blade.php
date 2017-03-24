@extends('activities.layout.activityLayout')

@section('actContent')
<link href='//fonts.googleapis.com/css?family=Dekko' rel='stylesheet'>
<link href='//fonts.googleapis.com/css?family=Space Mono' rel='stylesheet'>
<link href='//fonts.googleapis.com/css?family=Alice' rel='stylesheet'>
<style>
	.header {
		
    	background-color: rgba(153, 194, 255, 0.4);
		padding: 5px;
		border-bottom: solid 2px #cccccc;
		border-radius: 25px;
		text-align: center;
		font-size: 400px;
		font-family: 'Alice';
		font-weight: 900;
	}
	.wallpaper {
		background-image:url('P12_img/bg.jpg');
		background-color:#ccccff;
	}
	.content {
		font-family: 'Space Mono';
		font-size: 18px;
	}
</style>

<div class='header'>
	<h1>Mở rộng</h1> 
	
</div>
	<h3 class="content" align="right">
		<button type="button" class="btn btn-primary" onclick="JavaScript: next()">Next</button>
	</h3>
<hr>
<script language="JavaScript">
	var contentNow = 0;
	var contentArr = <?php echo json_encode($contentArr); ?>;
	var titleArr = <?php echo json_encode($titleArr); ?>;
	function next(){
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}
		if(contentNow < contentArr.length-1){
			contentNow = parseInt(contentNow) + 1;
		}else{
			window.alert("Bạn đã hoàn thành bài tập rồi");
		}
		for (var i = 0; i < contentArr[contentNow].length; i++) {
			editContent(contentArr[contentNow][i]);
		}

		while (document.getElementById("title_id").firstChild) {
			document.getElementById("title_id").removeChild(document.getElementById("title_id").firstChild);
		}
		editTitle(titleArr[contentNow]);
		
	}

	function editContent(text) {
		var node = document.createElement("div");
		var textnode = document.createTextNode(text);
		node.appendChild(textnode);
		document.getElementById("content_id").appendChild(node);
	}
	function editTitle(text) {
		var node = document.createElement("p");
		var textnode = document.createTextNode(text);
		node.appendChild(textnode);
		document.getElementById("title_id").appendChild(node);
	}
</script>

<body class='wallpaper'>
	<div class="content">
		<h3 id="title_id" align="center">{{ $titleArr[0]}}</h3>
	</div>
	<table align="center" class="content" id="content_id">
		@for ($i = 0; $i < count($contentArr[0]) ; $i++)
		<tr>
			<td>{{ $contentArr[0][$i]}}</td>
		</tr>
		@endfor
	</table>
</body>

@stop

@section('description')
In this activity,...
@stop
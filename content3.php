<script>uid="<?=$user_profile['id']?>"</script>


<div>
	<span><img src='https://graph.facebook.com/<?=$user_profile['id']?>/picture'/> Hi, <?=$user_profile['name']?></span>
	
	<ul id="nav" data-bind="template: { name: 'linktemp', foreach: links }"></ul>
	
	
	<script type="text/html" id="linktemp">
		<li data-bind="css: { selected: $data == viewModel.selectedLink() },
			click: function() { viewModel.selectedLink().sel(viewModel.selectedLink().img); viewModel.selectLink($data); }">
		<a href = '#'><img data-bind="attr: { src: $data.sel() }">${$data.name}</a></li>    
	</script>

</div>	

<div style="display:none; width:500px;">
	<div style="width:500px;" id="data" data-bind='template: { name: function(){ return viewModel.lightTemp();}, data: viewModel.selItemsName }'></div>
</div>	

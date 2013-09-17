<script>uid="<?=$user_profile['id']?>"</script>


<div>
	<ul id="nav" data-bind="template: { name: 'pageTemplate', foreach: pages }"></ul>
	
	
	<script type="text/html" id="pageTemplate">
		<li data-bind="css: { selected: $data == viewModel.selectedPage() },
                   click: function(){ viewModel.switchPage($data)}">
        	<a href = '#'><img data-bind="attr: { src: page_map[$data].selected_img() }">${$data}</a></li> 
	    </li> 
   
	</script>

</div>	

<div style="display:none; width:500px;">
	<div style="width:500px;" id="data" data-bind='template: { name: function(){ return viewModel.lightTemp();} , data: viewModel.selItemsName }'></div>
</div>	

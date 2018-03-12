<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="/">TO-DO List</a>
		</div>
	</div>
</nav>


<!-- To be deleted from code -->
<!--
<div
id="todotodo"
style="
	position: absolute;
	left: 30px;
	width: 300px;
	border: 1px dotted gray;
	padding: 15px;
	opacity: 0.4;
	user-select: none;
"
ondblclick="$(this).remove()"
onclick="loadNoodles()"
>
	Todo todo:
	<ul>
		<li>Displaying too long names categories and tasks</li>
	  <li> <em style="text-decoration: line-through">Seeds</em>, look for another approaches to create seeds</li>
	  <li>+- One dynamic modal for create/edit actions, +- unify same methods for tasks and categories (parent class, etc.)</li>
	  <li>+- Are there advantagers in such approach: after adding/editing/deleting list items don't reload whole lists, reload just affected items?</li>
	</ul>
</div>	

<script>
	function loadNoodles() {
		let currMpX, currMpY, t, l, initDpX, initDpY, initMpX, initMpY, md = false;
		$('#todotodo').mousemove(function(e){
			currMpX = e.pageX;
			currMpY = e.pageY;
			//console.log(x, y);
			if(md) {
				$(this).css('top', (currMpY-initMpY+initDpY)+'px');
				$(this).css('left', (currMpX-initMpX+initDpX)+'px');
			} 
		});
		$('#todotodo').on('mousedown', function(e){
			//console.log(x, y);
			
			initDpY = $(this).css('top').replace('px', '');
			initDpX = $(this).css('left').replace('px', '');
			
			initMpY = currMpY;
			initMpX = currMpX;
			//console.log(t, l);
			md = true;
		});
		$('#todotodo').on('mouseup', function(e){
			//console.log(x, y);
			md = false;
		});

	}
</script>
<!-- To be deleted from code -->

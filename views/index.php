<h1>PHP Test Application</h1>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>E-mail</th>
			<th>City</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($users as $user){?>
		<tr>
			<td><?=$user->getName()?></td>
			<td><?=$user->getEmail()?></td>
			<td><?=$user->getCity()?></td>
		</tr>
		<?}?>
	</tbody>
</table>

<div class="row">
	<div class="col-sm-offset-3 col-sm-6">
		<h2>Add user record</h2>
	</div>
</div>

<form method="post" action="create.php" class="form-horizontal">
	<div class="form-group">
		<label for="name" class="col-sm-3 control-label">Name:</label>
		<div class="col-sm-6">
			<input name="name" input="text" id="name" class="form-control"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for="email" class="col-sm-3 control-label">E-mail:</label>
		<div class="col-sm-6">
			<input name="email" input="text" id="email" class="form-control"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for="city" class="col-sm-3 control-label">City:</label>
		<div class="col-sm-6">
			<input name="city" input="text" id="city" class="form-control"/>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<button class="btn btn-primary">Create new row</button>
		</div>
	</div>
</form>
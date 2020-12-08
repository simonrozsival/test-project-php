<h1>PHP Test Application</h1>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>E-mail</th>
			<th>
				City
				<div class="input-group">
					<span class="input-group-addon">🔍</span>
					<input type="search" id="city-filter" class="form-control input-sm">
					<span class="input-group-btn">
						<button id="clear-search" class="btn btn-default btn-sm" type="button">✖</button>
					</span>
				</div>
			</th>
			<th>Phone</th>
		</tr>
	</thead>
	<tbody id="users">
		<?foreach($users as $user){?>
		<tr class="user">
			<td class="name"><?=$user->getName()?></td>
			<td class="email"><?=$user->getEmail()?></td>
			<td class="city"><?=$user->getCity()?></td>
			<td class="phone"><?=$user->getPhone()?></td>
		</tr>
		<?}?>
	</tbody>
</table>

<form id="add-user" method="post" action="create.php" class="form-horizontal">
	<div class="row">
		<div class="col-sm-offset-3 col-sm-6">
			<h2>Add user record</h2>

			<? if($result === "success"): ?>
			<p class="alert alert-success">User was added successfully.</p>
			<? endif ?>
		</div>
	</div>

	<div class="form-group <?=array_key_exists('name', $errors) ? 'has-error' : ''?>">
		<label for="name" class="col-sm-3 control-label">Name:</label>
		<div class="col-sm-6">
			<input name="name" input="text" id="name" class="form-control" value="<?=htmlspecialchars($values["name"])?>" />

			<? if(array_key_exists('name', $errors)): ?>
			<span class="help-block"><?=htmlspecialchars($errors["name"])?></span>
			<? endif ?>
		</div>
	</div>
	
	<div class="form-group <?=array_key_exists('email', $errors) ? 'has-error' : ''?>">
		<label for="email" class="col-sm-3 control-label">E-mail:</label>
		<div class="col-sm-6">
			<input name="email" input="text" id="email" class="form-control" value="<?=htmlspecialchars($values["email"])?>" />

			<? if(array_key_exists('email', $errors)): ?>
			<span class="help-block"><?=htmlspecialchars($errors["email"])?></span>
			<? endif ?>
		</div>
	</div>
	
	<div class="form-group <?=array_key_exists('city', $errors) ? 'has-error' : ''?>">
		<label for="city" class="col-sm-3 control-label">City:</label>
		<div class="col-sm-6">
			<input name="city" input="text" id="city" class="form-control" value="<?=htmlspecialchars($values["city"])?>" />
			
			<? if(array_key_exists('city', $errors)): ?>
			<span class="help-block"><?=htmlspecialchars($errors["city"])?></span>
			<? endif ?>
		</div>
	</div>
	
	<div class="form-group <?=array_key_exists('phone', $errors) ? 'has-error' : ''?>">
		<label for="phone" class="col-sm-3 control-label">Phone:</label>
		<div class="col-sm-6">
			<input name="phone" input="text" id="phone" class="form-control" value="<?=htmlspecialchars($values["phone"])?>" />
			
			<? if(array_key_exists('phone', $errors)): ?>
			<span class="help-block"><?=htmlspecialchars($errors["phone"])?></span>
			<? endif ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<button class="btn btn-primary">Create new row</button>
			<a href="index.php" class="btn btn-default">Reset</a>
		</div>
	</div>
</form>

<script>
function filterCities(searchTerm) {
	const rows = document.querySelectorAll(".user");
	for (let row of rows) {
		const cityCell = row.querySelector(".city");
		const city = cityCell.innerText.toLowerCase();
		if (city.includes(searchTerm)) {
			row.classList.remove("hidden");
		} else {
			row.classList.add("hidden");
		}
	}
}

function submitFormByAjax(data) {
	fetch("create.php", { method: "post", body: data })
		.then(res => res.text())
		.then(updatePage)
		.catch(err => console.error(err));
}

function updatePage(html) {
	const parser = new DOMParser();
	const doc = parser.parseFromString(html, "text/html");

	replaceChildren(doc, "add-user");
	replaceChildren(doc, "users");
	resetSearch();
}

function replaceChildren(doc, id) {
	const newEl = doc.getElementById(id);
	const oldEl = document.getElementById(id);
	oldEl.replaceChildren(...newEl.children);
}

function updateSearch() {
	const searchInput = document.getElementById("city-filter");
	filterCities(searchInput.value.toLowerCase());
}

function resetSearch() {
	const searchInput = document.getElementById("city-filter");
	searchInput.value = "";
	updateSearch();
}

window.onload = function () {
	const searchInput = document.getElementById("city-filter");
	searchInput.addEventListener("keyup", updateSearch);
	
	const clearSearchButton = document.getElementById("clear-search");
	clearSearchButton.addEventListener("click", e => {
		e.preventDefault();
		resetSearch();
	});

	const form = document.getElementById("add-user");
	form.addEventListener("submit", e => {
		e.preventDefault();

		const data = new FormData(form);
		submitFormByAjax(data);
	});
};
</script>

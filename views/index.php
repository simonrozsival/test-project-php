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
			<h2>Create user</h2>

			<? if($result === "success"): ?>
			<p class="alert alert-success">User was added successfully.</p>
			<? endif ?>
		</div>
	</div>

	<?= createInput("name", "Name", "text", $values, $errors) ?>
	<?= createInput("email", "E-mail", "email", $values, $errors) ?>
	<?= createInput("city", "City", "text", $values, $errors) ?>
	<?= createInput("phone", "Phone", "text", $values, $errors) ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<button class="btn btn-primary" id="create-user">Create</button>
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
	return fetch("create.php", { method: "post", body: data })
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
	const createUserButton = document.getElementById("create-user");
	form.addEventListener("submit", e => {
		e.preventDefault();
		createUserButton.disabled = true;

		const data = new FormData(form);
		submitFormByAjax(data)
			.finally(() => createUserButton.disabled = false);
	});
};
</script>

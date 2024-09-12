<div id="app">
	<div class="d-flex justify-content-end m-4">		
		<div>
			<button v-if="!isView" type="button" class="btn btn-light" @click="cancel">Cancel</button>
			<button type="button" class="btn btn-primary" @click="showUpdate" :disabled="saving">
				{{ isView ? "Edit": (saving ? "Updating...": "Update") }}
			</button>
		</div>		
	</div>
	<div class="card">		
		<div class="card-body">
			<p v-if="message" class="ms-4 text-success">{{ message }}</p>
			<ul v-for="error in errors">
				<li class="ms-4 text-danger">{{ error }}</li>
			</ul>			
			<div class="row">
				<div class="col">Title</div>
				<div class="col">
				<input type="text" v-model="updateBook.title" :disabled="isView"/>
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col">Author FirstName</div>
				<div class="col">
					<input type="text" v-model="updateBook.firstname" :disabled="isView" />
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col">Author LastName</div>
				<div class="col">
					<input type="text" v-model="updateBook.lastname" :disabled="isView" />
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col">Genre</div>
				<div class="col">
					<input type="text" v-model="updateBook.genre" :disabled="isView" />
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col">Published Year</div>
				<div class="col">
					<input type="text" v-model="updateBook.published_year" :disabled="isView" />
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col">Description</div>
				<div class="col">
					<textarea class="form-control" v-model="updateBook.description" :disabled="isView"></textarea>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>		
<script>
	$( document ).ready(function() {
		const data = <?= json_encode($data); ?>;
		new Vue({
			el: "#app",
			data: {			
				book: data,
				updateBook: data,
				message: '',
				errors: [],
				saving: false,
				isView: true
			},
			methods: {

				/**
				 * Show View mode
				 */
				showUpdate()
				{
					if (!this.isView) {
						this.editBook();
					} else {
						this.isView = false;
					}
				},

				/**
				 * Cancel Edit mode
				 */
				cancel()
				{
					this.isView = true;
				},

				/**
				 * Update book
				 */
				editBook() {
					const self = this;
					self.errors = [];
					self.message = '';
					if (!this.updateBook.title) {
						this.errors.push('The Title field is required.');
					}
					if (!this.updateBook.firstname) {
						this.errors.push("The Author FirstName field is required.");
					}
					if (!this.updateBook.lastname) {
						this.errors.push("The Author LastName field is required.");
					}
					if (!this.updateBook.genre) {
						this.errors.push("The Genre field is required.");
					}

					if (!this.updateBook.published_year) {
						this.errors.push("The Published Year field is required.");
					} else if (isNaN(this.updateBook.published_year) || this.updateBook.published_year.length !== 4) {
						this.errors.push("Published Year field must be year.");
					}

					if (!this.updateBook.description) {
						this.errors.push("The Description field is required.");
					} else if(this.updateBook.description.length < 100) {
						this.errors.push("The Description field must have at least 100 characters in length.");
					}

					if (self.errors.length > 0) {
						return 0;
					}

					self.saving = true;
					$.ajax({
						type : "POST",
						url : "/books/" + self.book.id,
						data : self.updateBook,
						success: function (result) {
							self.message = result.message;
							self.book = {...self.book, ...self.updateBook};						
							self.saving = false;
							self.isView = true;
						},
						error: function(error) {
							self.errors = 	error.responseJSON.errors;
							self.saving = false;
						}		
					});
				}
			},
			watch: {
				message: function(val) {
					setTimeout(() => {
						this.message = "";
					}, 1500);
				}
			},
			mounted(){
				const self = this;
				const a = self.book.author;			
				const lastname = a.substring((a.indexOf(" ") + 1));
				const firstname = a.substring(0, a.indexOf(" "));			
				self.updateBook = {
					...self.book,
					firstname: firstname,
					lastname: lastname
				}
				delete self.updateBook.author;			
			}
		})
	});	
</script>

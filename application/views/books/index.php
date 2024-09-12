<div id="app">
	<div class="d-flex justify-content-end me-4 mt-4">
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBookModal">Create</button>
	</div>
	<p v-if="message" class="ms-4 text-success">{{ deleteMessage }}</p>
	<table class="table">
		<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col">Title</th>
			<th scope="col">Author</th>
			<th scope="col">Genre</th>
			<th scope="col">Published Year</th>
			<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="book in books">
				<td>{{ book.id }}</td>
				<td>
					<a v-bind:href="'books/' + book.id">{{ book.title }}</a>
				</td>
				<td>{{ book.author }}</td>
				<td>{{ book.genre }}</td>
				<td>{{ book.published_year }}</td>
				<td>
					<button type="button" @click="() => setBook(book)" class="btn btn-link text-danger" data-bs-toggle="modal" data-bs-target="#confirmDelete">Delete</button>
					<a v-bind:href="'books/' + book.id" class="btn btn-link">View</a>
				</td>
			</tr>				
		</tbody>
	</table>
	
	<!-- Delete Modal -->

	<div class="modal" id="confirmDelete" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirm</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<ul v-for="error in errors">
					<li class="ms-4 text-danger">{{ error }}</li>
				</ul>			
				<p>Are you sure you want to delete book {{ selectedBook.title ?? '' }} ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" @click="deleteBook" class="btn btn-danger">Yes</button>
			</div>
			</div>
		</div>
	</div>

	<!-- Confirm Modal -->

	<div class="modal" id="finalDelete" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Message</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>{{ deleteMessage }}</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
			</div>
			</div>
		</div>
	</div>

	<!-- Create Modal -->
	<div class="modal" id="createBookModal" tabindex="-1" aria-labelledby="createBookModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Create Book</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p v-if="message" class="ms-4 text-success">{{ message }}</p>
					<ul v-for="error in errors">
						<li class="ms-4 text-danger">{{ error }}</li>
					</ul>			
					<div class="row m-4">
						<div class="col">Title</div>
						<div class="col">
							<input type="text" v-model="book.title"/>
						</div>
					</div>					
					<div class="row m-4">
						<div class="col">Author FirstName</div>
						<div class="col">
							<input type="text" v-model="book.firstname"/>
						</div>
					</div>					
					<div class="row m-4">
						<div class="col">Author LastName</div>
						<div class="col">
							<input type="text" v-model="book.lastname"/>
						</div>
					</div>					
					<div class="row m-4">
						<div class="col">Genre</div>
						<div class="col">
							<input type="text" v-model="book.genre"/>
						</div>
					</div>					
					<div class="row m-4">
						<div class="col">Published Year</div>
						<div class="col">
							<input type="text" v-model="book.published_year"/>
						</div>
					</div>					
					<div class="row m-4">
						<div class="col">Description</div>
						<div class="col">
							<textarea class="form-control" v-model="book.description"></textarea>
						</div>
					</div>
				</div>			
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" @click="submit" class="btn btn-primary" :disabled="saving">
						{{ saving ? "Submitting": "Submit" }}
					</button>
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
				books: data,
				errors: [],
				message: '',
				deleteMessage: '',
				selectedBook: {},
				saving: false,
				book: {
					title: '',
					firstname: '',
					lastname: '',
					genre: '',
					published_year: '',
					description: ''
				}
			},
			watch: {
				// Reset message after 1.5sec
				message: function(val) {
					setTimeout(() => {
						this.message = "";
					}, 1500);
				}			
			},
			methods: {

				/**
				 * Submit book
				 * 
				 */
				submit() {				
					const self = this;
					self.errors = [];
					self.message = "";

					if (!self.book.title) {
						self.errors.push('The Title field is required.');
					}
					if (!self.book.firstname) {
						self.errors.push("The Author FirstName field is required.");
					}
					if (!self.book.lastname) {
						self.errors.push("The Author LastName field is required.");
					}
					if (!self.book.genre) {
						self.errors.push("The Genre field is required.");
					}

					if (!self.book.published_year) {
						self.errors.push("The Published Year field is required.");
					} else if (isNaN(self.book.published_year) || self.book.published_year.length !== 4) {
						self.errors.push("Published Year field must be year.");
					}

					if (!self.book.description) {
						self.errors.push("The Description field is required.");
					} else if(self.book.description.length < 100) {
						self.errors.push("The Description field must have at least 100 characters in length.");
					}

					if (self.errors.length > 0) {
						return 0;
					}
					
					self.saving = true;

					// submit
					$.ajax({
						type : "POST",
						url : "/books/create",
						data : self.book,
						success: function (result) {
							self.message = result.message;
							self.clear();
						},
						error: function(err) {
							self.errors = err.responseJSON.errors;
							self.saving = false;
						}
					})
				},

				/** 
				 * Clear all datas in data that we used for form
				*/
				clear() {
					this.book = {
						title: '',
						firstname: '',
						lastname: '',
						genre: '',
						published_year: '',
						description: ''
					};
					this.errors = [];
					this.selectedBook = {};
					this.saving = false;
				},
				
				/**
				 * Set Book
				 */
				setBook(book) {
					this.selectedBook = book;
				},

				/**
				 * Delete Book
				 */
				deleteBook() {				
					var self = this;
					$.ajax({
						type : "GET",
						url : "/books/delete/"+self.selectedBook.id,
						success: function (result) {
							self.deleteMessage = result.message;
							self.clear();
							$('#confirmDelete').modal('hide');
							$('#finalDelete').modal('show');
						},
						error: function(err) {
							self.errors = err.responseJSON.errors;
						}		
					})
				}
			},
			mounted(){
				$('#createBookModal').on("hidden.bs.modal", () => {
					this.message = "";
					this.clear();
					location.reload();
				});
				$('#confirmDelete').on("hidden.bs.modal", () => {
					this.message = "";
					this.clear();
				});
				$('#finalDelete').on("hidden.bs.modal", () => {
					this.deleteMessage = "";
					location.reload();
				});
			}
		})
	});	
</script>

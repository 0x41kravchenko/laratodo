
let Category = {
	
	settings: {
		createCategoryModal: $('#create-category-modal'),
		editCategoryModal: $('#edit-category-modal'),
		createCategoryForm: $('#create-category-form'),
		editCategoryForm: $('#edit-category-form'),
		categoriesList: $('.categories-list'),
		activeCategoryId: 'all'
	},
	
	init: function() {
		Category.bindUIActions();
	},
	
	bindUIActions: function() {
		Category.settings.categoriesList.on('click', 'a.list-group-item', function(e) { // Filter tasks by active category
			e.preventDefault();
			Category.settings.categoriesList.find('.active').removeClass('active');
			$(this).addClass('active');
			Category.settings.activeCategoryId = $(this).data('category-id');
			Task.getTasks();
		});
		
		Category.settings.categoriesList.on('click', '.delete-category-icon', function(e) {
			e.stopPropagation(); // Seems like it doesn't disable parent's default event and opens href url,
			e.preventDefault();  // so we'll preventDefault here too
			let catId = $(this).closest('a').data('category-id');
			let csrf_token = $(this).data('csrf-token');
			Category.deleteCat(catId, csrf_token);
		});
		
		Category.settings.categoriesList.on('click', '.edit-category-icon', function(e) {
			e.stopPropagation(); // Seems like it doesn't disable parent's default event and opens href url,
			e.preventDefault();  // so we'll preventDefault here too
			let catId = $(this).closest('a').data('category-id');
			let catName = $(this).closest('a').children('.category-name').text();
			let catColor = $(this).closest('a').data('category-color');
			Category.settings.editCategoryForm.find('input[name="id"]').val(catId);
			Category.settings.editCategoryForm.find('input[name="name"]').val(catName);
			Category.settings.editCategoryForm.find('input[name="color"]').val(catColor);
			Category.settings.editCategoryForm.find('.form-errors').empty();
			Category.settings.editCategoryModal.modal('show');
		});
		
		Category.settings.editCategoryModal.on('submit', '#edit-category-form', function(e) {
			e.preventDefault();
			Category.editCat();
		});
		
		Category.settings.editCategoryModal.on('click', '#edit-category-button', function(e) {
			Category.editCat();
		});
		// or Category.settings.editCategoryModal.on('click', '#edit-category-button', Category.editCat);
		
		Category.settings.createCategoryModal.on('submit', '#create-category-form', function(e) {
			e.preventDefault();
			Category.createCat();
		});
		
		Category.settings.createCategoryModal.on('click', '#create-category-button', function(e) {
			Category.createCat();
		});
	},
	
	getCats: function() {
		let activeCatId = Category.settings.activeCategoryId;
		$.ajax({
			url: '/categories',
			method: 'GET',
			dataType: 'html',
			success: function(response) {
				Category.settings.categoriesList.html(response);
				// setting active category to one that was active before updating the list
				Category.settings.categoriesList.find('a.list-group-item.active').removeClass('active');
				Category.settings.categoriesList.find('a.list-group-item[data-category-id="' + activeCatId + '"]').addClass('active');
				
			},
			error: function(jqXHR, status, errorThrown) {
				let errorMessage = '<div class="alert alert-danger alert-message">Error updating categories list, please reload the page.</div>';
				Category.settings.categoriesList.html(errorMessage);
				console.error('Error updating categories list');
			}
		});
	},
	
	createCat: function() {

		let valErrors = validateInput(Category.settings.createCategoryForm.find('input[name="name"]'), 'required|min:2|max:16');
		if (!$.isEmptyObject(valErrors)) {
			Category.settings.createCategoryForm.find('.form-errors').html(errorsHTML(valErrors));
			return;
		}
	
		$.ajax({
			url: '/categories',
			method: 'POST',
			data: Category.settings.createCategoryForm.serialize(),
			success: function(response) {
				Category.settings.activeCategoryId = response;
				Category.getCats();
				Task.getTasks();
				Category.settings.createCategoryModal.modal('hide');
				Category.settings.createCategoryForm.find('.form-errors').empty();
				Category.settings.createCategoryForm.trigger('reset');
				Task.updateTaskFormsSelect();
			},
			error: function(jqXHR) {
				let responseErrors = $.isEmptyObject(jqXHR.responseJSON) ? null : jqXHR.responseJSON.errors;
				Category.settings.createCategoryForm.find('.form-errors').html(errorsHTML(responseErrors));
			}
		});
	},
	
	editCat: function() {

		let valErrors = validateInput(Category.settings.editCategoryForm.find('input[name="name"]'), 'required|min:2|max:16');
		if (!$.isEmptyObject(valErrors)) {
			Category.settings.editCategoryForm.find('.form-errors').html(errorsHTML(valErrors));
			return;
		}
	
		let catId = Category.settings.editCategoryForm.find('input[name="id"]').val();
		$.ajax({
			url: '/categories/' + catId,
			method: 'POST',
			data: Category.settings.editCategoryForm.serialize(),
			success: function() {
				Category.getCats();
				Category.settings.editCategoryModal.modal('hide');
				Task.getTasks();
				Task.updateTaskFormsSelect();
			},
			error: function(jqXHR) {
				console.error('Error editing category');
				let responseErrors = $.isEmptyObject(jqXHR.responseJSON) ? null : jqXHR.responseJSON.errors;
				Category.settings.editCategoryForm.find('.form-errors').html(errorsHTML(responseErrors));
			}
		});
	},
	
	deleteCat: function(id, csrf_token) {
		// If deleting category is active, then set "All" as active category.
		if (id == Category.settings.activeCategoryId) Category.settings.activeCategoryId = 'all';
		$.ajax({
			url: '/categories/' + id,
			method: 'POST',
			data: '_method=DELETE&_token=' + csrf_token,
			success: function(response) {
				Category.getCats();
				Task.getTasks();
				Task.updateTaskFormsSelect();
			},
			error: function(jqXHR, status, errorThrown) {
				console.error('Error deleting category');
			}
		});
	}
	
};



let Task = {
	
	settings: {
		createTaskModal: $('#create-task-modal'),
		editTaskModal: $('#edit-task-modal'),
		createTaskForm: $('#create-task-form'),
		editTaskForm: $('#edit-task-form'),
		tasksList: $('.tasks-list')
	},
	
	init: function() {
		Task.bindUIActions();
	},
	
	bindUIActions: function() {
		Task.settings.tasksList.on('click', '.delete-task-icon', function(e) {
			let taskId = $(this).closest('li').data('task-id');
			let csrf_token = $(this).data('csrf-token');
			Task.deleteTask(taskId, csrf_token);
		});
		
		Task.settings.tasksList.on('click', '.edit-task-icon', function(e) {
			let taskId = $(this).closest('li').data('task-id');
			let taskTitle = $(this).closest('li').find('.task-title').text();
			let taskDescr = $(this).closest('li').find('.task-description').text();
			let catId = $(this).closest('li').find('.task-category').data('category-id');
			Task.settings.editTaskForm.find('input[name="id"]').val(taskId);
			Task.settings.editTaskForm.find('input[name="title"]').val(taskTitle);
			Task.settings.editTaskForm.find('textarea[name="description"]').val(taskDescr);
			Task.settings.editTaskForm.find('option[selected="selected"]').removeProp('selected');
			Task.settings.editTaskForm.find('option[value="' + catId + '"]').prop('selected', 'selected');
			Task.settings.editTaskForm.find('.form-errors').empty();
			Task.settings.editTaskModal.modal('show');
		})
		
		Task.settings.editTaskModal.on('submit', '#edit-task-form', function(e) {
			e.preventDefault();
			Task.editTask();
		});
		
		Task.settings.editTaskModal.on('click', '#edit-task-button', function(e) {
			Task.editTask();
		});
		
		Task.settings.createTaskModal.on('submit', '#create-task-form', function(e) {
			e.preventDefault();
			Task.createTask();
		});
		
		Task.settings.createTaskModal.on('click', '#create-task-button', function(e) {
			Task.createTask();
		});
		
		Task.settings.createTaskModal.on('change', '#set-expiration', function(e) {
			let setExpirationStatus = Task.settings.createTaskModal.find('#set-expiration').prop('checked');
			Task.settings.createTaskForm.find('input[name="expiration-datetime"]').prop('disabled', !setExpirationStatus);
			Task.settings.createTaskForm.find('input[name="expiration-datetime-tz"]').prop('disabled', !setExpirationStatus);
			Task.settings.createTaskForm.find('.expiration-inputs label').toggleClass('disabled-input');
		});
		
		Task.settings.tasksList.on('change', '#task-status', function(e) {
			let taskId = $(this).closest('li').data('task-id');
			let taskStatus = $(this).prop('checked')?1:0;
			let csrf_token = $(this).closest('li').find('.delete-task-icon').data('csrf-token');
			Task.setTaskStatus(taskId, taskStatus, csrf_token);
		});
		
		Task.settings.createTaskModal.on('show.bs.modal', function(e) {
			let currentDatetime = new Date();
			let timezoneOffset = currentDatetime.getTimezoneOffset();
			let activeCatId = Category.settings.activeCategoryId;
			if (activeCatId == 'all' | activeCatId == 'my-tasks') { // If selected filter is "all tasks" or current user's tasks then set select intput category to "None" 
				activeCatId = 0;
			}
			Task.settings.createTaskForm.find('option[selected="selected"]').removeProp('selected');
			Task.settings.createTaskForm.find('option[value="' + activeCatId + '"]').prop('selected', 'selected');
			Task.settings.createTaskForm.find('input[name="expiration-datetime"]').val(dateWithOffsetToISOString(currentDatetime));
			Task.settings.createTaskForm.find('input[name="expiration-datetime-tz"]').val(timezoneOffsetToStr(timezoneOffset));
		});
	},
	
	getTasks: function() {
		let activeCatId = Category.settings.activeCategoryId;
		$.ajax({
			url: '/tasks?cat=' + activeCatId,
			method: 'GET',
			dataType: 'html',
			success: function(response) {
				Task.settings.tasksList.html(response);
			},
			error: function(jqXHR) {
				let errorMessage = '<div class="alert alert-danger alert-message">Error updating tasks list, please reload the page.</div>';
				Task.settings.tasksList.html(errorMessage);
				console.error('Error updating tasks list');
			}
		});
	},
	
	createTask: function() {

		let valErrors = validateInput(Task.settings.createTaskForm.find('input[name="title"]'), 'required|min:2|max:64');
		if (!$.isEmptyObject(valErrors)) {
			Task.settings.createTaskForm.find('.form-errors').html(errorsHTML(valErrors));
			return;
		}
		
		let expirationDt = Task.settings.createTaskForm.find('input[name="expiration-datetime"]').val();
		let expirationDtTz = Task.settings.createTaskForm.find('input[name="expiration-datetime-tz"]').val();
		let expiresAt = expirationDt + expirationDtTz;
		
		$.ajax({
			url: '/tasks',
			method: 'POST',
			data: Task.settings.createTaskForm.serialize() + '&expires_at=' + encodeURIComponent(expiresAt),
			success: function() {
				Task.getTasks();
				Category.getCats(); // update categories list counters
				Task.settings.createTaskModal.modal('hide');
				Task.settings.createTaskForm.find('.form-errors').empty();
				Task.settings.createTaskForm.trigger('reset');
				Task.settings.createTaskForm.find('.expiration-inputs label').removeClass('disabled-input');
			},
			error: function(jqXHR) {
				let responseErrors = $.isEmptyObject(jqXHR.responseJSON) ? null : jqXHR.responseJSON.errors;
				Task.settings.createTaskForm.find('.form-errors').html(errorsHTML(responseErrors));
			}
		});
	},
	
	editTask: function() {
	
		let valErrors = validateInput(Task.settings.editTaskForm.find('input[name="title"]'), 'required|min:2|max:64');
		if (!$.isEmptyObject(valErrors)) {
			Task.settings.editTaskForm.find('.form-errors').html(errorsHTML(valErrors));
			return;
		}
	
		let taskId = Task.settings.editTaskForm.find('input[name="id"]').val();
		$.ajax({
			url: '/tasks/' + taskId,
			method: 'POST',
			data: Task.settings.editTaskForm.serialize(),
			success: function() {
				Task.getTasks();
				Category.getCats(); // updating categories list counters
				Task.settings.editTaskModal.modal('hide');
			},
			error: function(jqXHR) {
				let responseErrors = $.isEmptyObject(jqXHR.responseJSON) ? null : jqXHR.responseJSON.errors;
				Task.settings.editTaskForm.find('.form-errors').html(errorsHTML(responseErrors));
			}
		});
	},
	
	deleteTask: function(id, csrf_token) {
		$.ajax({
			url: '/tasks/' + id,
			method: 'POST',
			data: '_method=DELETE&_token=' + csrf_token,
			success: function() {
				Task.getTasks();
				Category.getCats(); // refresh counters in categories list
			},
			error: function() {
				console.error('Error deleting task');
			}
		});
	},
	
	setTaskStatus: function(id, status, csrf_token) {
		$.ajax({
			url: '/tasks/' + id + '/set-status',
			method: 'POST',
			data: '_method=PUT&_token=' + csrf_token + '&completed=' + status,
			success: function() {
				Task.getTasks();
			},
			error: function() {
				console.error('Error setting task status');
			}
		});
	},
	
	updateTaskFormsSelect: function() { // Update both create task and edit task form's select input field
		$.ajax({
			url: '/categories/get-select-input',
			method: 'GET',
			dataType: 'html',
			success: function(response) {
				Task.settings.createTaskModal.find('.categories-select-input').html(response);
				Task.settings.editTaskModal.find('.categories-select-input').html(response);
			},
			error: function(jqXHR) {
				console.error('Error updating categories select input');
			}
		});
	}
	
};

let Auth = {
	
	settings: {
	
		navbar: $('#page-navbar'),
		
		registerForm: $('#register-form'),
		registerDropdown: $('#register-dropdown'),
		registerSubmitButton: $('#register-submit-button'),
		
		loginForm: $('#login-form'),
		loginDropdown: $('#login-dropdown'),
		loginSubmitButton: $('#login-submit-button'),
		logoutButton: $('#logout-button')
		
	},
	
	init: function() {
		Auth.bindUIActions();
	},
	
	bindUIActions: function() {
	
		Auth.settings.navbar.on('submit', '#register-form', function(e) {
			e.preventDefault();
			Auth.registerUser();
		});
		
		Auth.settings.navbar.on('submit', '#login-form', function(e) {
			e.preventDefault();
			let rememberMe = Auth.settings.loginForm.find('#remember-me').prop('checked')?1:0;
			Auth.loginUser(rememberMe);
		});
		
		Auth.settings.navbar.on('click', '#logout-button', function(e) {
			e.preventDefault();
			let csrftoken = $(this).data('csrf-token');
			Auth.logoutUser(csrftoken);
		});
	},
	
	registerUser: function() {
		let valErrors = validateInput(Auth.settings.registerForm.find('input[name="name"]'), 'required|min:2|max:64');
		$.extend(valErrors, validateInput(Auth.settings.registerForm.find('input[name="email"]'), 'required|email|max:64'));
		$.extend(valErrors, validateInput(Auth.settings.registerForm.find('input[name="password"]'), 'required|min:4|max:64|confirmed'));
		if (!$.isEmptyObject(valErrors)) {
			Auth.settings.registerForm.find('.form-errors').html(errorsHTML(valErrors));
			return;
		}
		
		$.ajax({
			url: '/register',
			method: 'POST',
			data: Auth.settings.registerForm.serialize(),
			success: function() {
				$(document).ajaxStop(function() {location.reload(true)});
			},
			error: function(jqXHR) {
				let responseErrors = $.isEmptyObject(jqXHR.responseJSON) ? null : jqXHR.responseJSON.errors;
				Auth.settings.registerForm.find('.form-errors').html(errorsHTML(responseErrors));
			}
		});
	},
	
	loginUser: function(rememberMe) {
	
		let valErrors = validateInput(Auth.settings.loginForm.find('input[name="email"]'), 'required|email');
		$.extend(valErrors, validateInput(Auth.settings.loginForm.find('input[name="password"]'), 'required'));
		if (!$.isEmptyObject(valErrors)) {
			Auth.settings.loginForm.find('.form-errors').html(errorsHTML(valErrors));
			return;
		}
	
		$.ajax({
			url: '/login',
			method: 'POST',
			data: Auth.settings.loginForm.serialize() + '&remember-me=' + rememberMe,
			success: function() {
				$(document).ajaxStop(function() {location.reload(true)});
			},
			error: function(jqXHR) {
				let responseErrors = $.isEmptyObject(jqXHR.responseJSON) ? null : jqXHR.responseJSON.errors;
				Auth.settings.loginForm.find('.form-errors').html(errorsHTML(responseErrors));
			}
		});
	},
	
	logoutUser: function(csrf_token) {
		$.ajax({
			url: '/logout',
			method: 'POST',
			data: '_token=' + csrf_token,
			success: function() {
				$(document).ajaxStop(function() {location.reload(true)});
			},
			error: function() {
				console.error('Error logging out');
			}
		});
	}
	
};

Category.init();
Task.init();
Auth.init();

/* Misc functions */

function errorsHTML(errorsObj) {
	let errorsDiv = '<div class="alert alert-danger">';
	// If errors list is empty, but error took place return general error text
	if ($.isEmptyObject(errorsObj)) {
		return errorsDiv + 'Error. Please reload the page, and try again.</div>'
	}
	
	errorsDiv += '<ul>';
	$.each(errorsObj, function(eoKey, eoValue) {
		$.each(eoValue, function(valKey, valValue) {
			errorsDiv += '<li>' + valValue + '</li>';
		});
	});
	errorsDiv += '</ul></div>';
	return errorsDiv;
}

function dateWithOffsetToISOString(date) {
	let fullYear = date.getFullYear();
	let month = date.getMonth()+1;
	let day = date.getDate();
	let hours = date.getHours();
	let minutes = date.getMinutes();
	let fullMonth = month<10 ? '0'+month : month;
	let fullDay = day<10 ? '0'+day : day;
	let fullHours = hours<10 ? '0'+hours : hours;
	let fullMinutes = minutes<10 ? '0'+minutes : minutes;
	
	return fullYear + '-' + fullMonth + '-' + fullDay + 'T' + fullHours + ':' + fullMinutes;
}

function timezoneOffsetToStr(tzOffset) {
	let inverseTzOffsetSign = tzOffset<=0 ? '+' : '-' ;  // (getting inverse timezone offset sign, since tzOffset of -X minutes == UTC+HH:MM)
	let offsetHours = Math.trunc(Math.abs(tzOffset) / 60);
	let offsetMinutes = Math.abs(tzOffset) % 60;
	let offsetFullHours = offsetHours<10 ? '0'+offsetHours : offsetHours;
	let offsetFullMinutes = offsetMinutes<10 ? '0'+offsetMinutes : offsetMinutes;
	
	return inverseTzOffsetSign + offsetFullHours + ':' + offsetFullMinutes;
}

// Form input validation function with Laravel-like errors return and validation rules: 'rule0[|rule1[:value]...]'
function validateInput(inputField, rulesStr) {
	let inputFieldName = inputField.attr('name');
	let inputFieldValue = inputField.val();
	let inputFieldLength = inputField.val().length;
	let errorsObj = {};
	
	// Converting rules string to object
	let rulesObj = {};
	rulesStr.split('|').map(function(str) {
		let arr = str.split(':');
		rulesObj[arr[0]] = isNaN(arr[1])?arr[1]:Number(arr[1]);
	});
	
	let testMin = true;
	let testEmail = true;
	let testConfirmation = true;
	let ruleCondition,
			ruleErrorMsg;
	
	$.each(rulesObj, function(rule, ruleVal) {
	
		ruleCondition = false;
		
		switch(rule) {
			case 'required':
				ruleCondition = inputFieldLength == 0;
				ruleErrorMsg = 'The ' + inputFieldName + ' field is required.';
				if (ruleCondition) { // If current rule did not pass validation do not test specified rules
					testMin = false;
					testEmail = false;
					testConfirmation = false;
				}
				break;
			case 'min':
				if (!testMin) break;
				ruleCondition = inputFieldLength < ruleVal;
				ruleErrorMsg = 'The ' + inputFieldName + ' must be at least ' + ruleVal + ' characters.';
				if (ruleCondition) { // If current rule did not pass validation do not test specified rules
					testConfirmation = false;
				}
				break;
			case 'max':
				ruleCondition = inputFieldLength > ruleVal;
				ruleErrorMsg = 'The ' + inputFieldName + ' may not be greater than ' + ruleVal + ' characters';
				if (ruleCondition) { // If current rule did not pass validation do not test specified rules
					testConfirmation = false;
				}
				break;
			case 'email':
				if (!testEmail) break;
				// Basic email check (could be improved), if invalid email won't be catched with this rule it will be validated 
				// on backend side 
				ruleCondition = !(/.+@.+\..+/.test(inputFieldValue));  
				ruleErrorMsg = 'The ' + inputFieldName + ' must be a valid email address.';
				break;
			case 'confirmed':
				if (!testConfirmation) break;
				let inputFieldConfirmedName = inputFieldName + '_confirmation';
				let inputFieldConfirmedValue = inputField.closest('form').find('input[name="' + inputFieldConfirmedName + '"]').val();
				ruleCondition = inputFieldValue !== inputFieldConfirmedValue;
				ruleErrorMsg = 'The ' + inputFieldName + ' confirmation does not match.';
				break;
			case '':
				console.error('Error. Empty validation rule is specified.');
				break;
			default:
				console.error('Error. Validation rule: "' + rule + '" is invalid or not supported yet.');
		}
		
		errorsObj = testValidationRule(errorsObj, ruleCondition, inputFieldName, ruleErrorMsg);
	
	});
	
	return errorsObj;
}

function testValidationRule(errorsObj, ruleStatus, inputName, errorMessage) {
	if (ruleStatus) {
		errorMessage = errorMessage.replace("%input%", inputName);
		if (typeof errorsObj[inputName] == 'undefined') { // If object property is undefined then define it with new value
			errorsObj[inputName] = [errorMessage];
		} else {  // Otherwise, append it
				errorsObj[inputName].push(errorMessage);
		}
	}
	return errorsObj;
}

const MODULE = {};

(function(self){

	self.DB = {
		opencart: {
			host: "",
			user: "",
			password: "",
			name: ""
		},

		solomono: {
			host: "",
			user: "",
			password: "",
			name: ""
		},

		connection: false
	};

	self.connectDatabase = function() {

		let validate = JSON.parse(self.validateInputOnEmpty());

		if(!validate.ok) {
			self.showNotification(validate.message);
			return false;
		}

		self.DB.opencart.host = document.getElementById("opencart-dbhost").value;
		self.DB.opencart.user = document.getElementById("opencart-dbuser").value;
		self.DB.opencart.password = document.getElementById("opencart-dbpass").value;
		self.DB.opencart.name = document.getElementById("opencart-dbname").value;

		self.DB.solomono.host = document.getElementById("solomono-dbhost").value;
		self.DB.solomono.user = document.getElementById("solomono-dbuser").value;
		self.DB.solomono.password = document.getElementById("solomono-dbpass").value;
		self.DB.solomono.name = document.getElementById("solomono-dbname").value;


		self.execDB(JSON.stringify({
			"opencart": {
				"host": self.DB.opencart.host,
				"user": self.DB.opencart.user,
				"password": self.DB.opencart.password,
				"name": self.DB.opencart.name,
			},

			"solomono": {
				"host": self.DB.solomono.host,
				"user": self.DB.solomono.user,
				"password": self.DB.solomono.password,
				"name": self.DB.solomono.name,
			}
		}), "database.php");

	};


	self.validateInputOnEmpty = function() {
		let nodes = document.querySelectorAll("input");
		let errors = [];
		for(let i = 0; i < nodes.length; i++){
			nodes[i].classList.remove("error");
			if(nodes[i].value === ""){
				nodes[i].classList.add("error");
				errors[i] = nodes[i];
			}
		}

		if(errors.length > 0){
			return JSON.stringify({
				ok: false,
				message: "All fields are required"
			});
		}

		return JSON.stringify({
			ok: true,
			message: ""
		});
	};

	self.execDB = function(params, url) {

		let form = new FormData();
		form.append("data", params);

		let xhr = new XMLHttpRequest();
		xhr.open("POST", "module/" + url);
		xhr.send(form);

		xhr.onreadystatechange = function() {
			if(this.readyState === 4 && this.status === 200)
			{
				let response = JSON.parse(this.responseText);

				if(response.connection === true)
				{
					self.DB.connection = true;
					self.nextStep(2);
				}

				self.showNotification(response.message);
				
			}
		}

	};

	self.nextStep = function(step) {
		document.getElementById("step-" + (step -1)).classList.remove("active");
		document.getElementById("step-" + (step - 1)).classList.add("complete");
		document.getElementById("step-" + step).classList.remove("disabled");
		document.getElementById("step-" + step).classList.add("active");

		self.step(step);
	}

	self.step = function(step) {

		if(step === 2) {
			document.getElementById("connect-database").classList.add("hidden");
			document.getElementById("block-step").classList.remove("hidden");
			self.showBlockStep("category");
			self.requestGET("load_categories", "category");
			self.showBlockStep("category_description");
			self.requestGET("load_categories_description", "category_description");
			self.nextStep(3);
		}

		else if(step === 3) {
			self.showBlockStep("product");
			self.requestGET("load_products", "product");
			self.showBlockStep("product_description");
			self.requestGET("load_products_description", "product_description");
			self.showBlockStep("product_to_category");
			self.requestGET("load_products_to_categories", "product_to_category");
			self.nextStep(4);
		}

		else if(step == 4) {
			self.showBlockStep("load_files");
			self.requestGET("load_files", "load_files");
		}

	};

	self.requestGET = function(filename, active) {
		let xhr = new XMLHttpRequest();
		xhr.open("GET", "module/" + filename + ".php");
		xhr.send();

		xhr.onreadystatechange = function() {
			if(this.readyState === 4 && this.status === 200)
			{
				let response = JSON.parse(this.responseText);
				if(response.ok === true){
					document.getElementById("p-" + active).classList.add("text-success");
					document.getElementById("p-" + active + "-time").innerHTML = "(" + response.time.toFixed(1) + " s.)";
				}else{
					self.showNotification(response.message);
				}
			}
		}
	}

	self.showNotification = function(message) {
		if(message !== ""){
			document.getElementById("notification").classList.remove("hidden");
			document.getElementById("notification-message").innerHTML = "";
			document.getElementById("notification-message").innerHTML = message;
		}
	}

	self.hideNotification = function() {
		document.getElementById("notification").classList.add("hidden");
		document.getElementById("notification-message").innerHTML = "";
	}

	self.showBlockStep = function(active) {
		document.getElementById("block-step-content").innerHTML = document.getElementById("block-step-content").innerHTML + '<h5><b id="p-' + active + '">' + active + '...</b> <small id="p-' + active + '-time"></small></h5>';
	}

	self.clearBlockStep = function() {
		document.getElementById("block-step-content").innerHTML = "";
	}

})(MODULE);
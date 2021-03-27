<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Transferring OpenCart DB - Solomono.</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>

<div class="container">

	<div class="row bs-wizard justify-content-center" style="border-bottom:0; margin-bottom: 50px;">
	                
	    <div class="col-xs-2 bs-wizard-step active" id="step-1">
	      <div class="text-center bs-wizard-stepnum">Step 1</div>
	      <div class="progress"><div class="progress-bar"></div></div>
	      <a href="#" class="bs-wizard-dot"></a>
	      <div class="bs-wizard-info text-center">Database connection</div>
	    </div>
	    
	    <div class="col-xs-2 bs-wizard-step disabled" id="step-2">
	      <div class="text-center bs-wizard-stepnum">Step 2</div>
	      <div class="progress"><div class="progress-bar"></div></div>
	      <a href="#" class="bs-wizard-dot"></a>
	      <div class="bs-wizard-info text-center">Moving categories</div>
	    </div>
	    
	    <div class="col-xs-2 bs-wizard-step disabled" id="step-3">
	      <div class="text-center bs-wizard-stepnum">Step 3</div>
	      <div class="progress"><div class="progress-bar"></div></div>
	      <a href="#" class="bs-wizard-dot"></a>
	      <div class="bs-wizard-info text-center">Moving products</div>
	    </div>
	    
	    <div class="col-xs-2 bs-wizard-step disabled" id="step-4">
	      <div class="text-center bs-wizard-stepnum">Step 4</div>
	      <div class="progress"><div class="progress-bar"></div></div>
	      <a href="#" class="bs-wizard-dot"></a>
	      <div class="bs-wizard-info text-center">Completion</div>
	    </div>

	</div>

	<div class="row hidden" id="notification">
		<div class="col-md-12">
			<div class="card card-body shadow-sm" id="notification-message"></div>
		</div>
	</div>

	<div class="row" id="connect-database">

		<div class="col-md-6">
			<div class="card shadow-sm">
				<div class="card-header">
					<div class="card-title">OpenCart Database</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>DB HOST</label>
						<input 
							type="text" 
							class="form-control form-control-lg" 
							placeholder="Database host" 
							id="opencart-dbhost"
							value="localhost" />
					</div>
					<div class="form-group">
						<label>DB USER</label>
						<input 
							type="text" 
							class="form-control form-control-lg" 
							placeholder="Database user" 
							id="opencart-dbuser"
							value="mysql" />
					</div>
					<div class="form-group">
						<label>DB PASSWORD</label>
						<input 
							type="text" 
							class="form-control form-control-lg" 
							placeholder="Database password" 
							id="opencart-dbpass"
							value="mysql" />
					</div>
					<div class="form-group">
						<label>DB NAME</label>
						<input 
							type="text" 
							class="form-control form-control-lg" 
							placeholder="Database name" 
							id="opencart-dbname"
							value="solomono_module" />
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card shadow-sm">
				<div class="card-header">
					<div class="card-title">Solomono Database</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>DB HOST</label>
						<input 
							type="text" 
							class="form-control form-control-lg" 
							placeholder="Database host"
							id="solomono-dbhost"
							value="localhost" />
					</div>
					<div class="form-group">
						<label>DB USER</label>
						<input 
							type="text" 
							class="form-control form-control-lg" 
							placeholder="Database user"
							id="solomono-dbuser"
							value="mysql" />
					</div>
					<div class="form-group">
						<label>DB PASSWORD</label>
						<input 
							type="text" 
							class="form-control form-control-lg" 
							placeholder="Database password"
							id="solomono-dbpass"
							value="mysql" />
					</div>
					<div class="form-group">
						<label>DB NAME</label>
						<input 
							type="text" 
							class="form-control form-control-lg" 
							placeholder="Database name"
							id="solomono-dbname"
							value="work" />
					</div>
				</div>
			</div>

			<div class="form-group  mt-5" style="text-align: right;">
				<button type="submit" class="btn btn-dark btn-lg" onclick="MODULE.connectDatabase()">Connect</button>
			</div>

		</div>

	</div>


	<div class="row hidden" id="block-step">
		<div class="col-md-12">
			<div class="card card-body shadow-sm" id="block-step-content"></div>
		</div>
	</div>


</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="assets/script.js"></script>
</body>
</html>
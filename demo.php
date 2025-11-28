<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A stepper plugin for Bootstrap 4.">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
    
    <title>Bootstrap stepper</title>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark text-white">
        <div class="container">
            <h1 class="mb-0 h5 py-1 mr-3">Bootstrap stepper</h1>
            <a href="https://github.com/Johann-S/bs-stepper" class="text-white py-1 text-decoration-none ml-auto mx-sm-0 order-0 order-sm-last" title="View project on GitHub">
                <span class="fab fa-github fa-lg d-block" aria-hidden="true"></span>
            </a>
            <button class="navbar-toggler ml-3" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/Johann-S/bs-stepper/tree/v1.7.0#how-to-use-it">Documentation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/Johann-S/bs-stepper/blob/master/CHANGELOG.md">Change log</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/Johann-S/bs-stepper/tree/v1.7.0#install">Download</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container flex-grow-1 flex-shrink-0 py-5">
        <div class="mb-5 p-4 bg-white shadow-sm">
            <h3>Linear stepper</h3>
            <div id="stepper1" class="bs-stepper">
                <div class="bs-stepper-header" role="tablist">
                    <div class="step" data-target="#test-l-1">
                        <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Email</span>
                        </button>
                    </div>
                    <div class="bs-stepper-line"></div>
                    <div class="step" data-target="#test-l-2">
                        <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Password</span>
                        </button>
                    </div>
                    <div class="bs-stepper-line"></div>
                    <div class="step" data-target="#test-l-3">
                        <button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">Validate</span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form onSubmit="return false">
                        <div id="test-l-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                            </div>
                            <button class="btn btn-primary" onclick="stepper1.next()">Next</button>
                        </div>
                        <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                            <button class="btn btn-primary" onclick="stepper1.next()">Next</button>
                        </div>
                        <div id="test-l-3" role="tabpanel" class="bs-stepper-pane text-center" aria-labelledby="stepper1trigger3">
                            <button class="btn btn-primary mt-5" onclick="stepper1.previous()">Previous</button>
                            <button type="submit" class="btn btn-primary mt-5">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="p-3 mt-auto bg-white shadow">
        <div class="container">
            <p class="text-muted text-center mb-0">
                Made with <span aria-label="love" class="text-danger">&hearts;</span> by <a href="https://github.com/Johann-S">Johann-S</a> and awesome <a href="https://github.com/Johann-S/bs-stepper/graphs/contributors">contributors</a>
            </p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        var stepper1
        var stepper2
        var stepper3
        var stepper4
        var stepperForm

        document.addEventListener('DOMContentLoaded', function() {
            stepper1 = new Stepper(document.querySelector('#stepper1'))
            stepper2 = new Stepper(document.querySelector('#stepper2'), {
                linear: false
            })
            stepper3 = new Stepper(document.querySelector('#stepper3'), {
                linear: false,
                animation: true
            })
            stepper4 = new Stepper(document.querySelector('#stepper4'))

            var stepperFormEl = document.querySelector('#stepperForm')
            stepperForm = new Stepper(stepperFormEl, {
                animation: true
            })

            var btnNextList = [].slice.call(document.querySelectorAll('.btn-next-form'))
            var stepperPanList = [].slice.call(stepperFormEl.querySelectorAll('.bs-stepper-pane'))
            var inputMailForm = document.getElementById('inputMailForm')
            var inputPasswordForm = document.getElementById('inputPasswordForm')
            var form = stepperFormEl.querySelector('.bs-stepper-content form')

            btnNextList.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    stepperForm.next()
                })
            })

            stepperFormEl.addEventListener('show.bs-stepper', function(event) {
                form.classList.remove('was-validated')
                var nextStep = event.detail.indexStep
                var currentStep = nextStep

                if (currentStep > 0) {
                    currentStep--
                }

                var stepperPan = stepperPanList[currentStep]

                if ((stepperPan.getAttribute('id') === 'test-form-1' && !inputMailForm.value.length) ||
                    (stepperPan.getAttribute('id') === 'test-form-2' && !inputPasswordForm.value.length)) {
                    event.preventDefault()
                    form.classList.add('was-validated')
                }
            })
        })
    </script>
</body>

</html>
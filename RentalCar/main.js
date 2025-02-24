async function getCars() {
    let res = await fetch('http://localhost:8080/cars');
    let cars = await res.json();

    cars.forEach(car => {
        car.price = parseFloat(car.price.replace("$", ""));
        document.querySelector('.car-list').innerHTML += `
            <div class="card col-sm-4">
                <div class="card-body">
                    <h5 class="text-center">${car.name}</h5>
                    <div>
                        <p>Horsepower: ${car.horsepower}</p>
                        <p>Engine capacity: ${car.enginecapacity}</p>
                        <dl>
                            <dt>Price:</dt>
                            <dd>1-3 days: ${"$" + Math.round(car.price)}</dd>
                            <dd>3-7 days: ${"$" + Math.round(car.price * 0.9)}</dd>
                            <dd>7-14 days: ${"$" + Math.round(car.price * 0.75)}</dd>
                            <dd>14+ days: ${"$" + Math.round(car.price * 0.6)}</dd>
                        </dl>
                    </div>
                    <a type="button" class="btn btn-light offset-md-3 col-md-6" onclick="carIdStorage(${car.id})" href="car.html"><strong>More</strong></a>
                </div>
            </div>
        `
    })
}

async function getCar() {
    let carId = localStorage.getItem('carId');
    let res = await fetch('http://localhost:8080/cars/' + carId);
    let car = await res.json();
    car.price = parseFloat(car.price.replace("$", ""));
    document.querySelector('.carInfo').innerHTML += `
        <div class="row col-sm-4">
            <h5 class="text-center">${car.name}</h5>
            <div>
                <p>Horsepower: ${car.horsepower}</p>
                <p>Engine capacity: ${car.enginecapacity}</p>
                <dl>
                    <dt>Price:</dt>
                    <dd>1-3 days: ${"$" + Math.round(car.price)}</dd>
                    <dd>3-7 days: ${"$" + Math.round(car.price * 0.9)}</dd>
                    <dd>7-14 days: ${"$" + Math.round(car.price * 0.75)}</dd>
                    <dd>14+ days: ${"$" + Math.round(car.price * 0.6)}</dd>
                </dl>
            </div>
            <p>Start date:</p>
            <input id="startDate" type="date"/>
            <p>End date:</p>
            <input id="endDate" type="date"/>
            <button class="btn button-light" onclick="createRequest()"> Create request</button>
        </div>
    `
}

function carIdStorage(carId) {
    localStorage.setItem("carId", carId);
}

function userAuthCheck() {
    let userName = "";
    if(localStorage.getItem("userName"))
        userName = localStorage.getItem("userName");
    if (!localStorage.getItem("isUserAuth")) {
        document.querySelector('header').innerHTML += `
            <div class="left"></div>
            <a class="text-white nav-link center" href="index.html">
                <h1>Rental Car</h1>
                <p>Rent what you want.</p>
            </a>
            <div class="right">
                <div style="margin-top: 30px; float: right">
                    <a class="text-white nav-link" style="float: left" href="login.html">Log In</a>
                    <p style="float: left; margin-right: 10px; margin-left: 10px"> | </p>
                    <a class="text-white nav-link" style="float: left" href="signup.html">Sign Up</a>
                </div>
            </div>
        `
    } else {
        document.querySelector('header').innerHTML += `
            <div class="left"></div>
            <a class="text-white nav-link center" href="index.html">
                <h1>Rental Car</h1>
                <p>Rent what you want.</p>
            </a>
            <div class="right">
                <div style="margin-top: 30px; float: right">
                    <p style="float: left; margin-right: 10px; margin-left: 10px"><i>${userName}</i> | </p>
                    <a class="text-white nav-link" style="float: left" href="#" onclick="logOut()">Log Out</a>
                </div>
            </div>
        `
    }
}

async function getUser(login) {
    let res = await fetch('http://localhost:8080/users/name/' + login);
    let user = await res.json();
    return user;
}

let isTextDangerView = false
async function logIn() {
    let login = document.getElementById('input-login').value;
    let password = document.getElementById('input-password').value;
    let user = await getUser(login);
    if (password == user.password) {
        localStorage.setItem("isUserAuth", "1");
        localStorage.setItem("userName", user.name);
        if (localStorage.getItem("isLogInTextDanger")) {
            localStorage.removeItem("isLogInTextDanger");
        }
        if (document.querySelector('.text-danger'))
            document.querySelector('.text-danger').remove();
        document.querySelector('.auth-success').innerHTML += `
            <h4 id="authSuccess" class="text-success text-center">Authorization successed</h4>
        `
        setTimeout(() => {location.href="index.html"}, 3000);
    } else {
        if (localStorage.getItem("isUserAuth")) {
            localStorage.removeItem("isUserAuth");
        }
        if (!isTextDangerView) {
            isTextDangerView = true;
            document.querySelector('.login-block').innerHTML += `
                <p class="text-danger text-center">Incorrect login or password</p>
            `
        }
    }
}

function logOut() {
    if (localStorage.getItem("isUserAuth")) {
        localStorage.removeItem("isUserAuth");
    }
    if (localStorage.getItem("userName")) {
        localStorage.removeItem("userName");
    }
    location.reload();
}

async function signUp() {
    let name = document.getElementById("input-login").value;
    let password = document.getElementById("input-password").value;
    let age = document.getElementById("input-age").value;
    let phone = document.getElementById("input-phone").value;

    let formData = new FormData();
    formData.append("name", name);
    formData.append("password", password);
    formData.append("age", age);
    formData.append("phone", phone);

    let res = await fetch('http://localhost:8080/users', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    if(data.status == "success") {
        document.querySelector('.center-block').remove();
        setTimeout(() => {location.href="index.html"}, 3000);
    } else {
        document.querySelector('.center-block').innerHTML += `
            <p class="text-danger text-center">Incorrect data</p>
        `
    }
}

let isTextDangerCarView = false
async function createRequest() {
    if (localStorage.getItem("isUserAuth")) {
        let startDate = new Date(document.getElementById("startDate").value);
        let endDate = new Date(document.getElementById("endDate").value);
        if (endDate > startDate) {
            let userId = await getUser(localStorage.getItem("userName"));
            let formData = new FormData();
            formData.append("userId", userId);
            formData.append("carId", localStorage.getItem("carId"));
            formData.append("startDate", startDate.toString())
            formData.append("endDate", endDate.toString())
            let res = await fetch('http://localhost:8080/users', {
                method: 'POST',
                body: formData
            });
            if (isTextDangerCarView) {
                document.querySelector('.carInfo').remove();
            }
            location.href="successRequestCreating.html"
        } else {
            if (!isTextDangerCarView) {
                isTextDangerCarView = true;
                document.querySelector('.carInfo').innerHTML += `
                    <p class="text-danger text-center">Start date equals or less end date</p>
                `
            }
        }
    }
}
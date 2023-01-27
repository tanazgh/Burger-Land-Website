var foods = [];
var user_id;
var total_cost = 0;
function addToCart(food_id, qty, name, price){
    var food = foods.find(x => x.id === food_id);
    if(food === undefined){
        food = {id: food_id, qty: 1, name: name, price: price};
        foods.push(food);
    }else{
        food.qty++;
    }
    total_cost += price;
    if(food.qty > qty){
        food.qty--;
        total_cost -= price;
        alert("Sorry, no more remains!");
    }
    setFoodNumber(food_id, qty, name, price);
    setCart();
}

function deleteFromCart(food_id, qty, name, price){
    var food = foods.find(x => x.id === food_id);
    food.qty--;
    total_cost -= price;
    setFoodNumber(food_id, qty, name, price);
    setCart();
}

function setFoodNumber(food_id, qty, name, price){
    var food = foods.find(x => x.id === food_id);
    if(food.qty == 0){
        document.getElementById('number' + food_id).innerHTML = `<a onclick='addToCart(${food_id}, ${qty}, "${name}", ${price})' class='orderbtn bi bi-cart-plus'>
        <svg hover: white;" xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cart-plus' viewBox='0 0 16 16'>" . 
        "<path d='M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z'/>" .
        "<path d='M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>" .
        "</svg>
        add to cart</a>`;
    }else{
        document.getElementById('number' + food_id).innerHTML = `<button class='plus' onclick='addToCart(${food_id}, ${qty}, "${name}", ${price})'>
        <img src='../images/plus.svg'></button>${food.qty}<button class='minus' onclick='deleteFromCart(${food_id}, ${qty}, "${name}", ${price})'>
        <img src='../images/minus.svg'></button>`;
    }
}

function setCart(){
    var ele = document.getElementById("order-list");
    ele.innerHTML = "";
    for(var food of foods){
        if(food.qty > 0){
            ele.innerHTML += `<div class="d-flex justify-content-between">
                <div>${food.name} <span class="yellow">X${food.qty}</span></div>
                <div>${food.price}</div>
                </div>
                <hr>`;
        }
    }
    ele.innerHTML += `<div class="d-flex justify-content-between">
    <div class="yellow">Total</div>
    <div>${total_cost.toFixed(2)}</div>
    </div>`;
}

function submitOrder(user){
    if(user === undefined){
        alert('please login then complete your order');
    }else{
        var ajaxURL = 'insert_cart.php';
        $.post(ajaxURL, {});
        ajaxURL = 'submit_order.php';
        for(var food of foods){
            var data = {food_id: food.id, qty: food.qty};
            $.post(ajaxURL, data);
        }
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Your Order Submitted',
            showConfirmButton: false,
            timer: 1500
        })
        setTimeout(function() {
            location.href='menu.php';
        }, 1500);
    }
}



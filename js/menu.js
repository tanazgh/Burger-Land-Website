var user_id;
function addToCart(food_id, qty, name, price){
    var order_qty = 0;
    var total_price = 0;
    $.get("get_session.php",{food_id: food_id}, function(data){
        d = JSON.parse(data);
        order_qty = d.order_qty;
        total_price = parseFloat(d.total_price);
        order_qty++;
        total_price += price;
        if(order_qty > qty){
            order_qty--;
            total_price -= price;
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: `No More ${name} Remains!`,
                showConfirmButton: false,
                timer: 3000
            })
        }else{
            $.post("set_session.php", {total_price: total_price, food_id: food_id, order_qty: order_qty});
        }
        setFoodNumber(food_id, qty, name, price, order_qty);
        setCart(food_id, name, price, order_qty, total_price);
    });
}

function deleteFromCart(food_id, qty, name, price){
    var order_qty = 0;
    var total_price = 0;
    $.get("get_session.php",{food_id: food_id}, function(data){
        d = JSON.parse(data);
        order_qty = d.order_qty;
        total_price = parseFloat(d.total_price);
        order_qty--;
        total_price -= price;
    
        $.post("set_session.php", {total_price: total_price, food_id: food_id, order_qty: order_qty});
        setFoodNumber(food_id, qty, name, price, order_qty);
        setCart(food_id, name, price, order_qty, total_price);
    });
}

function setFoodNumber(food_id, qty, name, price, order_qty){
    if(order_qty == 0){
        document.getElementById('number' + food_id).innerHTML = `<a onclick='addToCart(${food_id}, ${qty}, "${name}", ${price})' class='orderbtn bi bi-cart-plus'>
        <svg hover: white;" xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cart-plus' viewBox='0 0 16 16'>" . 
        "<path d='M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z'/>" .
        "<path d='M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>" .
        "</svg>
        add to cart</a>`;
    }else{
        document.getElementById('number' + food_id).innerHTML = `<button class='plus' onclick='addToCart(${food_id}, ${qty}, "${name}", ${price})'>
        <img src='../images/plus.svg'></button>${order_qty}<button class='minus' onclick='deleteFromCart(${food_id}, ${qty}, "${name}", ${price})'>
        <img src='../images/minus.svg'></button>`;
    }
}

function setCart(food_id, name, price, order_qty, total_price){
    var ele = document.getElementById(`l${food_id}`);
    if(order_qty != 0){
        ele.innerHTML = `<div class="d-flex justify-content-between">
        <div>${name} <span class="yellow">X${order_qty}</span></div>
        <div>${price}</div>
        </div>
        <hr>`;
    }else{
        ele.innerHTML = "";
    }
    document.getElementById("total_price").innerHTML = total_price.toFixed(2);
}

function submitOrder(user){
    if(user === undefined){
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: `Please Login Then Complete Your Order`,
            showConfirmButton: false,
            timer: 3000
        })
    }else{
        var ajaxURL = 'submit_order.php';
        $.post(ajaxURL, {});
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



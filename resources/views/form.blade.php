<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <style>
            form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            }

            h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            }

            .form-group {
            margin-bottom: 20px;
            }

            label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            }

            input {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            line-height: 1.5;
            box-sizing: border-box;
            transition: border-color 0.2s ease-in-out;
            }

            input:focus {
            outline: none;
            border-color: #007bff;
            }

            button[type="submit"] {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            }

            button[type="submit"]:hover {
            background-color: #0062cc;
            }
        </style>
    </head>
    
    <body>
        <form method="POST" action="{{ route('orders.create') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" >
            @csrf
          
            <h2>Order Details</h2>
            <div class="form-group">
                <label for="user_id">user_id</label>
                <input type="number" id = "user_id" name="user_id" placeholder="Example@: 1 ">
            </div>
            
            <div class="form-group">
                <label for="product_id">product_id</label>
                <input type="number" id="product_id" name="product_id" placeholder="Example@: 1"><br>
            </div>

            <div class="form-group">
                <label for="quantity">quantity</label>
                <input type="number" id="quantity" name="quantity" placeholder="Example@: 3 "><br>
            </div>
                    
            <div class="form-group">
                <label for="total_price">total_price</label>
                <input type="text" id = "total_price" name="total_price" placeholder="Example@: 1500.50 "><br>
            </div>    
            
            <div class="form-group">
                <label for="tenancy">tenancy</label>
                <input type="text" id="tenancy" name="tenancy" placeholder="Example@: 'contract', 'temporary'"><br>
            </div>
            
            <div class="form-group">
                <label for="status">status</label>
                <input type="text" id="status" name="status" placeholder="Example@: 'successful', 'failed', 'pending'" value = 'pending'><br>
            </div>

            <button type="submit">Pay with PayTabs</button><br>

        </form>
    </body>
</html>

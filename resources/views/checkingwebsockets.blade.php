<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
<!-- @vite('resources/js/app.js') -->


@vite('resources/js/app.js')

<script >

// window.axios.post("http://localhost:8000/api/company/register",{
//   name: "Company Name",
//   owner_name: "Owner Name",
//   email: "company@example.com",
//   commercial_register: "1234567890",
//   phone: "1234567891",
//   password: "secret",
//   confirm_password: "secret",
//   tax_record: "12345678900",
//   city: "New York",
//   location: {
//     latitude: 40.712776,
//     longitude: -74.005974
//   },
//   bank_account_num: 12345678901122
// })
//   .then(({ data }) => {
//     let token = data;
//     console.log(token);
    //
    // axios({
    //   method: "GET",
    //   url: "http://127.0.0.1:8000/api/user",
    //   headers: {
    //     Authorization: `Bearer ${token}`,
    //   },
    // }).then(({ data }) => {
    //   console.log(data);

    //   let echo = new Echo({
    //     broadcaster: "pusher",
    //     key: "s3cr3t",
    //     wsHost: "127.0.0.1",
    //     wsPort: 6001,
    //     forceTLS: false,
    //     cluster: "mt1",
    //     disableStats: true,
    //     authorizer: (channel, options) => {
    //       console.log(options);
    //       return {
    //         authorize: (socketId, callback) => {
    //           axios({
    //             method: "POST",
    //             url: "http://127.0.0.1:8000/api/broadcasting/auth",
    //             headers: {
    //               Authorization: `Bearer ${token}`,
    //             },
    //             data: {
    //               socket_id: socketId,
    //               channel_name: channel.name,
    //             },
    //           })
    //             .then((response) => {
    //               callback(false, response.data);
    //             })
    //             .catch((error) => {
    //               callback(true, error);
    //             });
    //         },
    //       };
    //     },
    //   });

    //   echo.private(`App.User.${data.id}`).listen(".new-message-event", (message) => {
    //     console.log(message);
    //   });
    // });
//   });

    // setTimeout(() => {
    //     window.Echo.private('OrderCreated.2')
    //     .listen('.Illuminate\Notifications\Events\BroadcastNotificationCreated',(e)=>{
    //         console.log(e);
    //     })
    // }, 200);

</script>
</html>
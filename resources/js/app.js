// import './bootstrap';

import Echo from "laravel-echo";
import Pusher from "pusher-js";
import axios from "axios";

window.Pusher = Pusher;

axios.post("http://localhost:8000/api/company/login",{
    phone: "1234567891",
    password: "secret"
})
  .then(({ data }) => {
    let token = data.data; 
    axios({
      method: "GET",
      url: "http://127.0.0.1:8000/api/auth",
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }).then(({ data }) => {
      console.log(data);

     window.Echo = new Echo({
        broadcaster: "pusher",
        wsHost: "127.0.0.1",
        wsPort: 6001,
        forceTLS: false,
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        encrypted: false,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        authorizer: (channel, options) => {
         
          return {
            authorize: (socketId, callback) => {
                axios.post('/api/broadcasting/auth', {
                    socket_id: socketId,
                    channel_name: channel.name
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                  callback(false, response.data);
                })
                .catch((error) => {
                    console.log(error);
                  callback(true, error);
                });
            },
          };
        },
      });
      window.Echo.private('OrderCreated.Company.'+data.id)
      .notification((notification) => {
          console.log(notification.message);
          console.log(data);
      });
    });
  });
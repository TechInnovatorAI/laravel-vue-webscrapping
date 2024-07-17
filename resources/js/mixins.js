import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

export default {
    methods: {
        noti(type, message) {
            const notyf = new Notyf();
            notyf.open({
                message: message,
                type: type,
                position: { x: 'right', y: 'top' },
                ripple: true,
                duration: 5000,
            });
        },
        isObjectEmpty(object){
            return Object.keys(object).length === 0;
        },
        checkLog() {
            let timestamp1 = localStorage.getItem('logTime');
            console.log('time : ', timestamp1);
            if(timestamp1){
                let timestamp2 = new Date().getTime();
                // Get the difference in milliseconds between the two timestamps.
                const differenceInMilliseconds = timestamp2 - timestamp1;
                // Convert the difference in milliseconds to seconds.
                const differenceInSeconds = differenceInMilliseconds / 1000;
                if(differenceInSeconds > 7200){
                    localStorage.clear();
                    this.noti("error", "Login session expired. Please login again");
                    window.location.href = '/';
                    // this.$router.push("/");
                }
            }else{
                localStorage.clear();
                this.noti("error", "Login session expired. Please login again");
                window.location.href = '/';
            }
        },
    },
}

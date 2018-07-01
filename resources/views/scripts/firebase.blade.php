<script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-database.js"></script>
<script>
    var config = {
        apiKey: "{{ env('FIREBASE_APIKEY') }}",
        authDomain: "{{ env('FIREBASE_AUTHDOMAIN') }}",
        databaseURL: "{{ env('FIREBASE_DATABASEURL') }}",
        projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
        storageBucket: "{{ env('FIREBASE_STORAGEBUCKET') }}",
        messagingSenderId: "{{ env('FIREBASE_MESSAGINGSENDER_ID') }}"
    }
    firebase.initializeApp(config)
    const database = firebase.database()
</script>
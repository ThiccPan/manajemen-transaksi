function geoFindMe() {
    console.log("clicked")
    const status = document.querySelector("#status");
    const mapLink = document.querySelector("#map-link");
    const coordinate = document.querySelector("#coordinate");

    mapLink.href = "";
    mapLink.textContent = "";

    function success(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        status.textContent = "";
        mapLink.href = `https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`
        mapLink.textContent = `Latitude: ${latitude} °, Longitude: ${longitude} °`;
        coordinate.value = `https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`
    }

    function error() {
        status.textContent = "Unable to retrieve your location";
    }

    if (!navigator.geolocation) {
        status.textContent = "Geolocation is not supported by your browser";
    } else {
        status.textContent = "Locating…";
        navigator.geolocation.getCurrentPosition(success, error);
    }
}

window.onload = (event) => {
    geoFindMe()
}
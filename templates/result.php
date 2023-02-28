<script>
// Initialize and add the map
function initMap() {
    // The location of user
    const user = { lat: %s, lng: %s };
    // The map, centered at user
    const map = new google.maps.Map(document.getElementById("go-ip-info-map"), {
      zoom: 4,
      center: user,
    });
    // The marker, positioned at user
    const marker = new google.maps.Marker({
      position: user,
      map: map,
    });
}
window.initMap = initMap;

</script>
<style> 
.entry-title, .wp-block-post-title {
    display: none;
    }
</style>

<div class="go-ip-info-div">
    <table class="go-ip-info-table">
    <thead>
        <tr>
            <th>IP Address</th>
            <th>%s</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td>Country</td>
        <td>%s</td>
    </tr>
    <tr>
    <tr>
        <td>State</td>
        <td>%s</td>
    </tr>
    <tr>
    <tr class="active-row">
        <td>City</td>
        <td>%s</td>
    </tr>
    <tr>
        <td>ISP</td>
        <td>%s</td>
    </tr>
    <tr>
        <th colspan="2" rowspan="2" id="go-ip-info-map">
        </th>
    </tr>
    <tr>
    </tr>
    </tbody>
    </table>
</div>
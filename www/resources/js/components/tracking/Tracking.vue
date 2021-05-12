<template>
    <l-map style="height: 500px"
        :zoom="zoom"
        :center="center">
        <l-tile-layer :url="url"></l-tile-layer>
        <l-marker
            :lat-lng="markerPartenza"
            :icon="carIcon"
            >
            <l-tooltip :options="markerToolTipOptions">Partenza!</l-tooltip>
        </l-marker>
        <l-marker
            :lat-lng="markerArrivo"
            :icon="carIcon"
            >
            <l-tooltip :options="markerToolTipOptions">Arrivo!</l-tooltip>
        </l-marker>
        <l-polyline :lat-lngs="polyline.latlngs" :color="polyline.color"></l-polyline>
    </l-map>
</template>

<style scoped>

</style>

 <!--
    select replace(replace(replace(replace(json_data, '"', ''), ':', ','), '{', '['), '}', ']')
    from
    (
	    select JSON_ARRAYAGG(JSON_OBJECT(latitude, longitude)) as json_data from tracking_data
    ) tmp
-->
<script>
/* OpenStreetMap VueJS.
    components  https://vue2-leaflet.netlify.app/components/
    examples    https://vue2-leaflet.netlify.app/examples/
*/
import { latLng, icon } from "leaflet";
import { LMap, LTileLayer, LMarker, LPopup, LTooltip, LPolyline } from "vue2-leaflet";
import 'leaflet/dist/leaflet.css'

export default {
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LPopup,
        LTooltip,
        LPolyline
    },

    // #region Properties
    data() {
        return {
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            zoom: 15,
            center: [44.63002610819176, 10.898761096541586],
            markerPartenza: [44.63002610819176, 10.898761096541586],
            markerArrivo: [44.639588952874, 10.895800884133756],
            center: [44.63002610819176, 10.898761096541586],
            polyline: {
                latlngs: [[44.63002610819176, 10.898761096541586], [44.631296413785286, 10.899925236101957], [44.63186251927835, 10.90050730588214], [44.63191774878691, 10.90050730588214], [44.63186251927835, 10.900546110534155], [44.6327737994488, 10.901283398922388], [44.633726486145825, 10.902234112896693], [44.63447205613009, 10.902117698940655], [44.63473438403166, 10.901011766358302], [44.63502432401692, 10.89949838492982], [44.63524522970001, 10.898314843043442], [44.63565942558927, 10.896471622072857], [44.635963167362426, 10.89563732205459], [44.63623929486748, 10.894783619710319], [44.63626863739, 10.893510969631148], [44.63791344704865, 10.894785544684487], [44.639588952874, 10.895800884133756]],
                color: 'red'
            },
            // markers tooltip options
            markerToolTipOptions: {
                permanent: true,
                opacity: 1
            },
            // markers custom icons
            carIcon: icon({
                iconUrl: "https://image.flaticon.com/icons/png/512/65/65578.png",
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            }),
        }
    },
    // #endregion Properties

    // #region Component Life Cycle
    created() {
    },
    mounted() {
        console.log('Tracking.vue mounted')
        console.log(this.$route.query.session_id)
    }
    // #endregion Component Life Cycle
}
</script>

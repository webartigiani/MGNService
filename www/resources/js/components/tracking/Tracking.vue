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
            zoom: 20,
            center: [44.6465813, 10.930903],
            markerPartenza: [44.6465813, 10.930903],
            markerArrivo: [44.6465684, 10.9309019],
            polyline: {
                latlngs: [[44.6465813, 10.930903], [44.6466012, 10.9308719], [44.6465852, 10.9309243], [44.6465338, 10.9308492], [44.646624, 10.9308389], [44.6466018, 10.9308856], [44.6466109, 10.9308886], [44.6466177, 10.9308606], [44.6466028, 10.9309107], [44.6465774, 10.9309388], [44.6465925, 10.9308977], [44.6465939, 10.9309149], [44.6465823, 10.9309155], [44.6465823, 10.9309155], [44.6465966, 10.9308948], [44.6465822, 10.9309138], [44.6465862, 10.9308831], [44.6465903, 10.9309046], [44.6465997, 10.9308354], [44.6465756, 10.9308172], [44.6466091, 10.9308138], [44.6466852, 10.9307479], [44.6467362, 10.9305028], [44.6466463, 10.9303789], [44.6465728, 10.9303123], [44.6465087, 10.9302178], [44.6462673, 10.9299666], [44.6462313, 10.9299402], [44.6462039, 10.9299099], [44.6460319, 10.9298425], [44.6459019, 10.929745], [44.6457975, 10.9296068], [44.6457478, 10.9295207], [44.6455545, 10.9294242], [44.6453243, 10.9291733], [44.6452862, 10.9291339], [44.6452293, 10.9289783], [44.6452223, 10.9289227], [44.6453301, 10.9287835], [44.6454783, 10.9286409], [44.6455237, 10.9283303], [44.6455697, 10.9282132], [44.6456499, 10.9280746], [44.645698, 10.9278787], [44.6457541, 10.9277809], [44.6458256, 10.9275032], [44.6459594, 10.9274308], [44.6460193, 10.9274632], [44.6460358, 10.9275341], [44.6460358, 10.9275341], [44.6460336, 10.927516], [44.6461129, 10.9275416], [44.6461129, 10.9275416], [44.6461745, 10.9275467], [44.6463166, 10.9276331], [44.6463967, 10.927697], [44.6464381, 10.9277056], [44.6465645, 10.9277974], [44.6466262, 10.9278283], [44.6466708, 10.9278922], [44.6466708, 10.9278922], [44.6468706, 10.9280854], [44.6470917, 10.9281542], [44.6471732, 10.9282056], [44.6472042, 10.9282301], [44.6475296, 10.9283935], [44.6475727, 10.9285812], [44.6476285, 10.9285796], [44.6476163, 10.9285712], [44.6476721, 10.9286574], [44.6475964, 10.9286917], [44.6474928, 10.9289131], [44.647422, 10.9290523], [44.6474386, 10.9292573], [44.6473013, 10.9294596], [44.6472476, 10.9297365], [44.6471938, 10.9298542], [44.6470842, 10.9302305], [44.6470175, 10.9304184], [44.6469424, 10.9303572], [44.6469524, 10.9305969], [44.6469236, 10.9304252], [44.6469229, 10.9305277], [44.6468606, 10.930566], [44.6467537, 10.9304697], [44.6466866, 10.9303655], [44.646631, 10.9304651], [44.6466552, 10.9307495], [44.6465537, 10.9307807], [44.6465684, 10.9309019]],
                color: 'red'
            },
            // markers tooltip options
            markerToolTipOptions: {
                permanent: true,
                opacity: 0.2
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

<template>
  <div>
    <div class="form-group w-100">
      <GmapAutocomplete
        @place_changed="setPlace"
        class="form-control"
        :value="selectedAddress"
      />
      <input type="hidden" name="address" :value="selectedAddress" />
    </div>
    <div class="form-group wt-formmap w-100">
      <div class="wt-locationmap">
        <GmapMap
          style="width: 100%; height: 210px;"
          :zoom="zoom"
          :center="latLng || { lat: 10, lng: 10 }"
          :options="options"
          @click="mapClick"
          ref="map"
        >
          <GmapMarker
            v-if="latLng && latLng.lat && latLng.lng"
            :position="latLng"
          />
        </GmapMap>
      </div>
    </div>
    <input type="hidden" name="latitude" :value="latLng && latLng.lat" />
    <input type="hidden" name="longitude" :value="latLng && latLng.lng" />
  </div>
</template>

<script>
export default {
  props: ["latitude", "longitude", "address", "needgeocode"],
  data() {
    return {
      latLng:
        this.latitude && this.longitude
          ? { lat: +this.latitude, lng: +this.longitude }
          : null,
      zoom: this.latitude && this.longitude ? 18 : 1,
      options: {
        streetViewControl: false,
      },
      latitudePlaceholder: Vue.prototype.trans("lang.ph_enter_latitude"),
      longitudePlaceholder: Vue.prototype.trans("lang.ph_enter_logitude"),
      selectedAddress: this.address,
    };
  },
  mounted() {
    if (this.needgeocode === "1") {
      this.getLatLng();
    }
  },
  methods: {
    mapClick(event) {
      this.latLng = {
        lat: event.latLng.lat(),
        lng: event.latLng.lng(),
      };
    },
    setPlace(event) {
      this.latLng = {
        lat: event.geometry.location.lat(),
        lng: event.geometry.location.lng(),
      };

      this.selectedAddress = event.formatted_address;
      console.log(event);

      this.zoom = 18;
    },
    getLatLng() {
      let i = 1;
      const interval = setInterval(() => {
        if (i === 6) {
          clearInterval(interval);
          return;
        }
        if ("google" in window) {
          this.getGeometryPlacesService();
          clearInterval(interval);
          return;
        }
        i++;
      }, 500);
    },
    getGeometryPlacesService() {
      let request = {
        query: this.address,
        fields: ["name", "geometry"],
      };
      let service = new google.maps.places.PlacesService(
        document.createElement("span")
      );

      service.findPlaceFromQuery(request, (results, status) => {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          this.latLng = {
            lat: results[0].geometry.location.lat(),
            lng: results[0].geometry.location.lng(),
          };
        }
      });
    },
  },
};
</script>

<style scoped></style>

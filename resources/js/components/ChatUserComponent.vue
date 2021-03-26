<template>
  <div class="chat-users-container" v-if="notify">
    <input
      type="text"
      class="search-input w-100"
      placeholder="Search..."
      v-model="searchUserInput"
    />
    <div class="chat-users-list wt-verticalscrollbar wt-dashboardscrollbar">
      <div>
        <div
          v-for="(user, index) in filteredUsers"
          :key="index"
          @click="startChat(user.id)"
          class="wt-ad"
          v-bind:class="[
            user.id == active_id ? 'wt-active' : '',
            user.status_class,
          ]"
        >
          <figure v-if="user.image">
            <img :src="image_path + user.image" :alt="user.image_name" />
          </figure>
          <div class="wt-adcontent">
            <h3 v-if="user.name">{{ user.name }}</h3>
            <span v-if="user.tagline">{{ user.tagline }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="chat-users-container" v-else>
    <input
      type="text"
      class="search-input w-100"
      placeholder="Search..."
      v-model="searchUserInput"
    />
    <div class="chat-users-list wt-verticalscrollbar wt-dashboardscrollbar">
      <div>
        <div
          v-for="(user, index) in filteredUsers"
          :key="index"
          @click="startChat(user.id)"
          class="wt-ad"
          v-bind:class="[user.id == active_id ? 'wt-active' : '']"
        >
          <figure v-if="user.image">
            <img :src="image_path + user.image" :alt="user.image_name" />
          </figure>
          <div class="wt-adcontent">
            <h3 v-if="user.name">{{ user.name }}</h3>
            <span v-if="user.tagline">{{ user.tagline }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Event from "../event.js";
export default {
  data() {
    return {
      users: [],
      active: false,
      messages: [],
      active_id: "",
      notify: true,
      image_path: APP_URL,
      searchUserInput: "",
    };
  },
  methods: {
    startChat(id) {
      this.notify = false;
      this.active_id = id;
      let self = this;
      axios
        .post(APP_URL + "/message-center/get-messages", {
          sender_id: id,
        })
        .then(function(response) {
          self.messages = response.data.messages;
          Event.$emit("chat-start", {
            user_id: id,
            chat: true,
            messages: self.messages,
          });
          Event.$emit("active-user", { user: response.data.selected, id: id });
        });
      self.messages = [];
    },
  },
  computed: {
    filteredUsers() {
      return this.users.filter((user) => {
        return (
          user.name
            .toLowerCase()
            .indexOf(this.searchUserInput.toLocaleLowerCase()) > -1
        );
      });
    },
  },
  mounted: function() {
    Event.$on("chat-users", (data) => {
      this.users = data.users;
    });
  },
  created() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("u")) {
      this.active_id = urlParams.get("u");
      console.log(this.active_id);
      this.startChat(this.active_id);
    }
  },
};
</script>

<style>
.users {
  background-color: #fff;
  border-radius: 3px;
}
</style>

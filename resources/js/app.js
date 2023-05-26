import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import { createApp } from "vue";
import Book from "../components/Book.vue";

createApp(Book).mount("#book");

import Member from "../components/Member.vue";

createApp(Member).mount("#member");

import User from "../components/User.vue";

createApp(User).mount("#user");

import Issuing from "../components/Issuing.vue";

createApp(Issuing).mount("#issuing");

import Return from "../components/Return.vue";

createApp(Return).mount("#return");

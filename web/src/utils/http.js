import axios from "axios";
const apiUrl = import.meta.env.VITE_API_URL;

const http = axios.create({
  baseURL: apiUrl,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

export default http;

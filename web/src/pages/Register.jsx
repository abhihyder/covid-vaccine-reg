import { useState, useEffect } from "react";
import http from "../utils/http";

export default () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    nid: "",
    vaccine_center_id: "",
  });
  const [vaccineCenters, setVaccineCenters] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchVaccineCenters = async () => {
      http
        .get("/vaccine-centers")
        .then(({ data }) => {
          setVaccineCenters(data.data.vaccine_centers);
          setLoading(false);
        })
        .catch((error) => {
          console.error("Error fetching vaccine centers", error);
          setLoading(false);
        });
    };

    fetchVaccineCenters();
  }, []);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (
      !formData.name ||
      !formData.email ||
      !formData.nid ||
      !formData.vaccine_center_id
    ) {
      alert("Please fill out all the fields.");
      return;
    }

    try {
      // Send the form data to the backend API
      const response = await http.post("/register", formData);

      // Handle the response from the server
      if (response.status === 201) {
        alert("Registration successful! Check your email for confirmation.");
        setFormData({
          name: "",
          email: "",
          nid: "",
          vaccine_center_id: "",
        });
      } else {
        alert("Failed to register. Please try again.");
      }
    } catch (error) {
      console.error("Error submitting registration", error);
      alert("An error occurred while registering. Please try again.");
    }
  };

  return (
    <div className="min-h-screen bg-gray-100 flex items-center justify-center">
      <div className="w-full max-w-lg p-8 bg-white rounded-lg shadow-md">
        <h1 className="text-2xl font-semibold text-center text-gray-700 mb-6">
          Vaccine Registration
        </h1>
        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label
              htmlFor="name"
              className="block text-sm font-medium text-gray-700"
            >
              Full Name
            </label>
            <input
              type="text"
              name="name"
              id="name"
              value={formData.name}
              onChange={handleChange}
              className="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>

          <div>
            <label
              htmlFor="email"
              className="block text-sm font-medium text-gray-700"
            >
              Email
            </label>
            <input
              type="email"
              name="email"
              id="email"
              value={formData.email}
              onChange={handleChange}
              className="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>

          <div>
            <label
              htmlFor="nid"
              className="block text-sm font-medium text-gray-700"
            >
              NID (10 or 17 digits)
            </label>
            <input
              type="text"
              name="nid"
              id="nid"
              value={formData.nid}
              onChange={handleChange}
              className="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
              pattern="\d{10}|\d{17}"
            />
          </div>

          <div>
            <label
              htmlFor="vaccine_center_id"
              className="block text-sm font-medium text-gray-700"
            >
              Vaccine Center
            </label>
            {loading ? (
              <p>Loading vaccine centers...</p>
            ) : (
              <select
                name="vaccine_center_id"
                id="vaccine_center_id"
                value={formData.vaccine_center_id}
                onChange={handleChange}
                className="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              >
                <option value="">Select a center</option>
                {vaccineCenters.map((center) => (
                  <option key={center.id} value={center.id}>
                    {center.name}
                  </option>
                ))}
              </select>
            )}
          </div>

          <button
            type="submit"
            className="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            Register
          </button>
        </form>
      </div>
    </div>
  );
};

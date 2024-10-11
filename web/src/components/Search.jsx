import { useState } from "react";
import http from "../utils/http";

export default function SearchVaccineRegistration() {
  const [nid, setNid] = useState("");
  const [schedule, setSchedule] = useState(null);

  const handleSearch = (e) => {
    e.preventDefault();
    setSchedule({});
    if (nid.trim()) {
      http
        .get(`search/${nid}`)
        .then(({ data }) => {
          setSchedule(data.data.schedule);
        })
        .catch((err) => {
          console.error(err);
          alert("Something went wrong, please try again.");
        });
    } else {
      alert("Please enter a valid NID");
    }
  };

  const scheduleRender = (schedule) => {
    switch (schedule.status) {
      case "not_registered":
        return (
          <p className="ml-3 mb-3 font-normal text-gray-500 dark:text-gray-400">
            We couldn't find any registration associated with this NID.
            <a
              href="/register"
              className="ml-2 inline-flex font-medium items-center text-blue-600 hover:underline"
            >
              Register here.
            </a>
          </p>
        );
      case "not_scheduled":
        return (
          <p className="text-yellow-600">
            Your registration is approved, but a vaccination date has not been
            scheduled yet. Please wait for further updates.
          </p>
        );
      case "scheduled_date_over":
        return (
          <p className="text-red-600">
            The scheduled vaccination date has passed. Please contact support to
            reschedule.
          </p>
        );
      case "scheduled":
        return (
          <p className="text-green-600">
            Your vaccination is scheduled on {schedule.scheduled_date}. Please make sure
            to attend on the scheduled date at {schedule.vaccine_center.name}.
          </p>
        );
      case "vaccinated":
        return (
          <p className="text-blue-600">
            Congratulations! You have been vaccinated. Stay healthy!
          </p>
        );
      default:
        return (
          <p className="text-gray-600">
            We couldn't retrieve any information with this NID. Please check the
            number and try again.
          </p>
        );
    }
  };

  return (
    <>
      <div className="flex items-center justify-center mt-10 bg-white">
        <div className="w-full max-w-md mx-auto rounded-lg p-8">
          <h1 className="text-2xl font-semibold text-center text-gray-700 mb-6">
            Search Vaccine Registration
          </h1>

          {/* Display the schedule result based on NID search */}
          {schedule && schedule.status && (
            <div className="mb-4">{scheduleRender(schedule)}</div>
          )}

          <form onSubmit={handleSearch} className="space-y-4">
            <div>
              <label
                htmlFor="nid"
                className="block text-sm font-medium text-gray-700"
              >
                Enter your NID
              </label>
              <input
                type="text"
                id="nid"
                name="nid"
                placeholder="Enter NID (10 or 17 digits)"
                value={nid}
                onChange={(e) => setNid(e.target.value)}
                className="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
              />
            </div>

            <div className="text-center">
              <button
                type="submit"
                className="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
              >
                Search
              </button>
            </div>
          </form>
        </div>
      </div>
    </>
  );
}

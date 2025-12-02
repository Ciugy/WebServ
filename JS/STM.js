// server.mjs just incase

//import express from "express";
//import cors from "cors";
//import GtfsRealtimeBindings from "gtfs-realtime-bindings";

// const API_KEY = "l744f8136f92e54fd985b15f92bf6705e2";
// const STM_URL = "https://api.stm.info/pub/od/gtfs-rt/ic/v2/vehiclePositions";

// async function getStmVehicles() {
//   const response = await fetch(STM_URL, {
//     headers: {
//       accept: "application/x-protobuf",
//       apikey: API_KEY,
//     },
//   });

//   if (!response.ok) {
//     throw new Error(`STM error: ${response.status} ${response.statusText}`);
//   }

//   const buffer = await response.arrayBuffer();
//   const byteArray = new Uint8Array(buffer);

//   // Decode protobuf -> JS objects (FeedMessage) :contentReference[oaicite:5]{index=5}
//   const feed =
//     GtfsRealtimeBindings.transit_realtime.FeedMessage.decode(byteArray);

//   const simplified = feed.entity
//     .filter((e) => e.vehicle && e.vehicle.position)
//     .map((e) => ({
//       id: e.id,
//       routeId: e.vehicle.trip?.routeId ?? null,
//       tripId: e.vehicle.trip?.tripId ?? null,
//       latitude: e.vehicle.position.latitude,
//       longitude: e.vehicle.position.longitude,
//       speedKph: e.vehicle.position.speed ?? null,
//       occupancyStatus: e.vehicle.occupancyStatus ?? null,
//     }));

//   return simplified;
// }

// // API endpoint
// app.get("/api/buses", async (req, res) => {
//   try {
//     const data = await getStmVehicles();
//     res.json({
//       count: data.length,
//       updatedAt: new Date().toISOString(),
//       vehicles: data,
//     });
//   } catch (err) {
//     console.error(err);
//     res.status(500).json({ error: err.message });
//   }
// });

// JS/STM.js
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Server listening on http://localhost:${PORT}`);
  console.log("Try GET http://localhost:3000/api/buses");
});

const statusEl = document.getElementById("status");
const tbody = document.querySelector("#busTable tbody");
const refreshBtn = document.getElementById("refreshBtn");

async function loadBuses() {
  statusEl.innerHTML = 'Loading data <span class="spinner"></span>';
  tbody.innerHTML = "";

  try {
    const res = await fetch("http://localhost:3000/api/buses");

    if (!res.ok) {
      throw new Error(`HTTP ${res.status}`);
    }

    const data = await res.json();
    statusEl.textContent = `Fetched ${data.count} vehicles at ${data.updatedAt}`;

    data.vehicles.slice(0, 30).forEach((v, index) => {
      const tr = document.createElement("tr");

      function td(text) {
        const cell = document.createElement("td");
        cell.textContent = text ?? "";
        return cell;
      }

      tr.appendChild(td(index + 1));
      tr.appendChild(td(v.id));
      tr.appendChild(td(v.routeId));
      tr.appendChild(td(v.tripId));
      tr.appendChild(td(v.latitude.toFixed(5)));
      tr.appendChild(td(v.longitude.toFixed(5)));
      tr.appendChild(td(v.speedKph != null ? v.speedKph.toFixed(1) : ""));
      tr.appendChild(td(v.occupancyStatus));

      tbody.appendChild(tr);
    });
  } catch (err) {
    console.error(err);
    statusEl.textContent = "Error loading data: " + err.message;
  }
}

refreshBtn.addEventListener("click", loadBuses);

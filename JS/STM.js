const API_KEY = "l744f8136f92e54fd985b15f92bf6705e2";
const STM_URL = "https://api.stm.info/pub/od/gtfs-rt/ic/v2/vehiclePositions";

async function getStmVehicles() {
  const response = await fetch(STM_URL, {
    headers: {
      accept: "application/x-protobuf",
      apikey: API_KEY,
    },
  });

  if (!response.ok) {
    throw new Error(`STM error: ${response.status} ${response.statusText}`);
  }

  const buffer = await response.arrayBuffer();
  const byteArray = new Uint8Array(buffer);

  // Decode protobuf -> JS objects (FeedMessage) :contentReference[oaicite:5]{index=5}
  const feed =
    GtfsRealtimeBindings.transit_realtime.FeedMessage.decode(byteArray);

  // Simplify: just keep a few useful fields for the front-end
  const simplified = feed.entity
    .filter((e) => e.vehicle && e.vehicle.position)
    .map((e) => ({
      id: e.id,
      routeId: e.vehicle.trip?.routeId ?? null,
      tripId: e.vehicle.trip?.tripId ?? null,
      latitude: e.vehicle.position.latitude,
      longitude: e.vehicle.position.longitude,
      speedKph: e.vehicle.position.speed ?? null,
      occupancyStatus: e.vehicle.occupancyStatus ?? null,
    }));

  return simplified;
}

// API endpoint for your front-end
app.get("/api/buses", async (req, res) => {
  try {
    const data = await getStmVehicles();
    res.json({
      count: data.length,
      updatedAt: new Date().toISOString(),
      vehicles: data,
    });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: err.message });
  }
});

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Server listening on http://localhost:${PORT}`);
  console.log("Try GET http://localhost:3000/api/buses");
});

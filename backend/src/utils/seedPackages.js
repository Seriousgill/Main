import { connectDB } from '../config/db.js';
import Package from '../models/Package.js';
import { defaultPackages } from './defaults.js';

await connectDB();
for (const pkg of defaultPackages) {
  await Package.findOneAndUpdate({ name: pkg.name }, pkg, { upsert: true });
}
console.log('Packages seeded');
process.exit(0);

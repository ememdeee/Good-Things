import { Button } from '@/components/ui/button'

const manufacturers = [
  'Acura', 'BMW', 'Chevrolet', 'Chrysler', 'Dodge', 'Ford', 'Ferrari', 'GMC', 
  'Honda', 'Infiniti', 'Jeep', 'Kia', 'Lexus', 'Mazda', 'Mercedes-Benz', 
  'Nissan', 'Porsche', 'Ram', 'Rolls-Royce', 'Subaru', 'Tesla', 'Toyota', 
  'Volkswagen', 'Volvo'
].sort()

export function ManufacturerDirectory() {
  return (
    <section className="py-12">
      <div className="container mx-auto px-4">
        <h2 className="text-2xl font-bold text-center mb-6">
          Window Stickers Lookup By VIN for All Manufacturers
        </h2>

        <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
          {manufacturers.map((brand) => (
            <Button
              key={brand}
              variant="ghost"
              className="w-full justify-start px-4 py-2 h-auto text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 rounded-md"
            >
              {brand}
            </Button>
          ))}
        </div>
      </div>
    </section>
  )
}


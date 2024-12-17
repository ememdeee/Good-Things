import { CheckCircle } from 'lucide-react'

export function Stats() {
  return (
    <section className="py-16 bg-white">
      <div className="container mx-auto px-4">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div className="flex items-center space-x-4">
            <CheckCircle className="h-6 w-6 text-green-500" />
            <div>
              <p className="text-sm text-gray-600">Free VIN Check:</p>
              <p className="font-bold">By VIN & Plate</p>
            </div>
          </div>
          <div className="flex items-center space-x-4">
            <CheckCircle className="h-6 w-6 text-green-500" />
            <div>
              <p className="text-sm text-gray-600">Daily VIN Searches:</p>
              <p className="font-bold">45,000+</p>
            </div>
          </div>
          <div className="flex items-center space-x-4">
            <CheckCircle className="h-6 w-6 text-green-500" />
            <div>
              <p className="text-sm text-gray-600">VIN Checked On:</p>
              <p className="font-bold">70 Databases</p>
            </div>
          </div>
          <div className="flex items-center space-x-4">
            <CheckCircle className="h-6 w-6 text-green-500" />
            <div>
              <p className="text-sm text-gray-600">Report Coverage:</p>
              <p className="font-bold">Extensive History</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}


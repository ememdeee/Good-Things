import { Shield, Car, FileText, DollarSign } from 'lucide-react'

export function Features() {
  return (
    <section className="py-20 bg-gray-50">
      <div className="container mx-auto px-4">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-bold mb-4">
            Sell Your Car Faster with Complete Transparency
          </h2>
          <p className="text-xl text-gray-600 max-w-2xl mx-auto">
            Our comprehensive reports and original window stickers give buyers the confidence they need to make a purchase decision.
          </p>
        </div>
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <Shield className="h-12 w-12 text-blue-600 mb-4" />
            <h3 className="text-xl font-bold mb-2">Complete History</h3>
            <p className="text-gray-600">
              Access detailed accident history, service records, and ownership information from 70+ databases.
            </p>
          </div>
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <Car className="h-12 w-12 text-blue-600 mb-4" />
            <h3 className="text-xl font-bold mb-2">Original Window Sticker</h3>
            <p className="text-gray-600">
              Show potential buyers your vehicle&apos;s original features, options, and MSRP.
            </p>
          </div>
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <FileText className="h-12 w-12 text-blue-600 mb-4" />
            <h3 className="text-xl font-bold mb-2">Detailed Reports</h3>
            <p className="text-gray-600">
              Get comprehensive insights including title information, recalls, and market value.
            </p>
          </div>
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <DollarSign className="h-12 w-12 text-blue-600 mb-4" />
            <h3 className="text-xl font-bold mb-2">Maximize Value</h3>
            <p className="text-gray-600">
              Sellers with complete documentation get up to 15% more for their vehicles.
            </p>
          </div>
        </div>
      </div>
    </section>
  )
}


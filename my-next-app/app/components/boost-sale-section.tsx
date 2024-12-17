import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"
import { TrendingUp, Shield, Users, DollarSign } from 'lucide-react'

export function BoostSaleSection() {
  return (
    <section className="py-16 bg-gradient-to-br from-blue-50 to-purple-50 relative overflow-hidden">
      <div className="container mx-auto px-4">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <div className="space-y-6">
            <h2 className="text-3xl font-bold tracking-tight sm:text-4xl md:text-5xl text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
              Boost Your Sale with Verified Reports
            </h2>
            <p className="text-xl text-gray-600">
              Did you know that sellers sharing detailed reports tend to get higher car offers? Transparency builds trust with potential buyers and helps your vehicle stand out in a competitive market. By showcasing essential insights, you can attract serious buyers and ensure you get the value your car truly deserves. Trust and data make all the difference!
            </p>
            <Button size="lg" className="mt-4 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 transition-all duration-300">
              Get Your Verified Report
            </Button>
          </div>
          <div className="grid grid-cols-2 gap-6">
            {[
              { icon: TrendingUp, title: "Higher Offers", description: "Detailed reports often lead to better offers from potential buyers.", color: "text-blue-500" },
              { icon: Shield, title: "Build Trust", description: "Transparency creates confidence in your vehicle's condition and history.", color: "text-green-500" },
              { icon: Users, title: "Attract Buyers", description: "Stand out in a competitive market with comprehensive vehicle information.", color: "text-purple-500" },
              { icon: DollarSign, title: "Fair Value", description: "Ensure you get the true value your car deserves with data-backed insights.", color: "text-yellow-500" },
            ].map((feature, index) => (
              <Card key={index} className="group hover:shadow-lg transition-all duration-300">
                <CardContent className="p-6 bg-gradient-to-br from-white to-gray-100 group-hover:from-blue-50 group-hover:to-purple-50 transition-all duration-300">
                  <feature.icon className={`h-10 w-10 ${feature.color} mb-4 transform group-hover:scale-110 transition-transform duration-300`} />
                  <h3 className="text-lg font-semibold mb-2 group-hover:text-blue-600 transition-colors duration-300">{feature.title}</h3>
                  <p className="text-gray-600 group-hover:text-gray-700 transition-colors duration-300">{feature.description}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </div>
      <div 
        className="absolute inset-0 bg-grid-pattern opacity-5"
        style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
        }}
      ></div>
    </section>
  )
}


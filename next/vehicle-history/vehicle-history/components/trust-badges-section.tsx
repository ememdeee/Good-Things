import { Shield, Lock } from 'lucide-react'
import { Badge } from "@/components/ui/badge"
import { Card, CardContent } from "@/components/ui/card"

export function TrustBadgesSection() {
  return (
    <section className="py-16 bg-gradient-to-br from-blue-50 via-white to-purple-50">
      <div className="container mx-auto px-4">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
            Your Trust, Our Promise
          </h2>
          <p className="text-lg text-gray-600 max-w-2xl mx-auto">
            We're committed to providing you with a seamless, secure experience backed by our unwavering guarantee of quality and protection.
          </p>
        </div>
        <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
          <Card className="overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <CardContent className="p-6 flex items-center space-x-4">
              <div className="bg-green-100 p-3 rounded-full">
                <Shield className="h-8 w-8 text-green-600" />
              </div>
              <div>
                <Badge variant="secondary" className="mb-2">100% Satisfaction Guaranteed</Badge>
                <h3 className="text-xl font-semibold mb-2">Unmatched Quality Assurance</h3>
                <p className="text-gray-600">
                  If you're not completely satisfied with our service, we'll make it right or refund your purchase. Your peace of mind is our top priority.
                </p>
              </div>
            </CardContent>
          </Card>
          <Card className="overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <CardContent className="p-6 flex items-center space-x-4">
              <div className="bg-blue-100 p-3 rounded-full">
                <Lock className="h-8 w-8 text-blue-600" />
              </div>
              <div>
                <Badge variant="secondary" className="mb-2">Safe & Secure Checkout</Badge>
                <h3 className="text-xl font-semibold mb-2">Bank-Level Security</h3>
                <p className="text-gray-600">
                  Shop with confidence knowing your personal and payment information is protected by state-of-the-art encryption technology.
                </p>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </section>
  )
}


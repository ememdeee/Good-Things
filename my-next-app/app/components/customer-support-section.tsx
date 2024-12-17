import { Card, CardContent } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Clock, MessageCircle, ThumbsUp, ArrowRight } from 'lucide-react'
import Image from 'next/image'

const supportMetrics = [
  {
    icon: ThumbsUp,
    value: "98%",
    label: "Customer Satisfaction",
    description: "Consistently exceeding expectations"
  },
  {
    icon: MessageCircle,
    value: "10 min",
    label: "Average Response",
    description: "Swift, efficient support"
  },
  {
    icon: Clock,
    value: "24/7",
    label: "Availability",
    description: "Round-the-clock assistance"
  }
]

const teamMembers = [
  { name: "Sarah", role: "Senior Support", image: "/testimonial.webp" },
  { name: "Mike", role: "Team Lead", image: "/testimonial2.webp" },
  { name: "Anna", role: "Technical Expert", image: "/testimonial3.webp" }
]

export function CustomerSupportSection() {
  return (
    <section className="py-24 bg-gradient-to-br from-blue-50 via-white to-purple-50 relative overflow-hidden">
      <div className="container mx-auto px-4">
        <div className="text-center max-w-3xl mx-auto mb-16">
          <Badge variant="secondary" className="mb-4">
            Expert Support Team
          </Badge>
          <h2 className="text-4xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
            Your Success Is Our Priority
          </h2>
          <p className="text-lg text-gray-600">
            Experience exceptional support from our dedicated team of vehicle history experts. 
            We&apos;re here around the clock to ensure you get the assistance you need, when you need it.
          </p>
        </div>

        <div className="relative mb-16">
          <div className="flex justify-center mb-8">
            <div className="relative w-48 h-16">
              {teamMembers.map((member, index) => (
                <div
                  key={index}
                  className="absolute w-16 h-16 rounded-full overflow-hidden border-4 border-white shadow-lg"
                  style={{ left: `${index * 30}px` }}
                >
                  <Image
                    src={member.image}
                    alt={member.name}
                    fill
                    className="object-cover"
                  />
                </div>
              ))}
            </div>
          </div>
        </div>

        <div className="grid md:grid-cols-3 gap-8 mb-12">
          {supportMetrics.map((metric, index) => (
            <div key={index}>
              <Card className="h-full hover:shadow-lg transition-all duration-300 group">
                <CardContent className="p-6">
                  <div className="flex flex-col items-center text-center space-y-4">
                    <div className="p-3 rounded-full bg-blue-100 group-hover:bg-blue-200 transition-colors duration-300">
                      <metric.icon className="w-8 h-8 text-blue-600" />
                    </div>
                    <h3 className="text-3xl font-bold text-gray-900">{metric.value}</h3>
                    <div>
                      <p className="font-semibold text-gray-900">{metric.label}</p>
                      <p className="text-sm text-gray-600">{metric.description}</p>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>
          ))}
        </div>

        <div className="text-center">
          <Button 
            size="lg"
            className="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 transition-all duration-300 group"
          >
            Connect With Us
            <ArrowRight className="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" />
          </Button>
        </div>
      </div>

      <div 
        className="absolute inset-0 bg-grid-pattern opacity-5 pointer-events-none"
        style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
        }}
      ></div>
    </section>
  )
}
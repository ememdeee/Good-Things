'use client'

import { useState } from 'react'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Search, Shield, Clock, FileText, AlertTriangle } from 'lucide-react'
import Image from 'next/image'

export function LicensePlateLookupContent() {
  const [state, setState] = useState('')

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-100 via-white to-purple-100">
      <div className="container mx-auto px-4 py-12">
        <div className="text-center max-w-3xl mx-auto mb-12">
          <Badge variant="secondary" className="mb-4">
            License Plate Lookup
          </Badge>
          <h1 className="text-4xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
            Instant Vehicle History by License Plate
          </h1>
          <p className="text-lg text-gray-600">
            Get comprehensive vehicle information using just the license plate number. Fast, accurate, and secure.
          </p>
        </div>

        <Card className="max-w-2xl mx-auto mb-12">
          <CardHeader>
            <CardTitle>Enter License Plate Details</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="grid gap-4">
              <div className="grid grid-cols-2 gap-4">
                <Input placeholder="License Plate Number" className="text-lg" />
                <Select value={state} onValueChange={setState}>
                  <SelectTrigger>
                    <SelectValue placeholder="Select State" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="CA">California</SelectItem>
                    <SelectItem value="NY">New York</SelectItem>
                    <SelectItem value="TX">Texas</SelectItem>
                    {/* Add more states as needed */}
                  </SelectContent>
                </Select>
              </div>
              <Button className="w-full bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 transition-all duration-300">
                <Search className="mr-2 h-4 w-4" />
                Search Vehicle History
              </Button>
            </div>
          </CardContent>
        </Card>

        <div className="grid md:grid-cols-2 gap-12 items-center mb-16">
          <div className="space-y-6">
            <h2 className="text-3xl font-bold">Why Use License Plate Lookup?</h2>
            <ul className="space-y-4">
              {[
                { icon: Shield, text: "Verify vehicle ownership and registration details" },
                { icon: Clock, text: "Access real-time, up-to-date vehicle information" },
                { icon: FileText, text: "Get comprehensive vehicle history reports" },
                { icon: AlertTriangle, text: "Identify potential issues or red flags" },
              ].map((item, index) => (
                <li key={index} className="flex items-center space-x-3">
                  <item.icon className="w-6 h-6 text-blue-600" />
                  <span>{item.text}</span>
                </li>
              ))}
            </ul>
            <Button variant="outline">Learn More About Our Services</Button>
          </div>
          <div className="relative">
            <Image
              src="/placeholder.svg"
              alt="License Plate Lookup Illustration"
              width={500}
              height={500}
              className="rounded-lg shadow-xl"
            />
          </div>
        </div>

        <div className="bg-white rounded-xl p-8 shadow-lg mb-16">
          <h2 className="text-2xl font-bold mb-6 text-center">What's Included in Our License Plate Lookup?</h2>
          <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            {[
              "Vehicle Specifications",
              "Ownership History",
              "Accident Reports",
              "Title Information",
              "Lien Records",
              "Theft Records",
              "Odometer Readings",
              "Registration Status",
              "Recall Information",
            ].map((item, index) => (
              <div key={index} className="flex items-center space-x-2">
                <div className="w-2 h-2 bg-blue-600 rounded-full"></div>
                <span>{item}</span>
              </div>
            ))}
          </div>
        </div>

        <div className="text-center max-w-3xl mx-auto">
          <h2 className="text-3xl font-bold mb-4">Ready to Get Started?</h2>
          <p className="text-lg text-gray-600 mb-6">
            Our license plate lookup service provides you with instant, accurate information about any vehicle. Try it now!
          </p>
          <Button size="lg" className="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 transition-all duration-300">
            Start Your Search
          </Button>
        </div>
      </div>
    </div>
  )
}


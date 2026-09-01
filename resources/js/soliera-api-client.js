/**
 * Soliera Hotel API Client
 * Handles API calls to the Soliera hotel management system
 */

class SolieraApiClient {
    constructor(config) {
        this.baseUrl = config.baseUrl || '';
        this.token = config.token || '';
    }

    /**
     * Get authorization headers
     */
    getHeaders() {
        return {
            'Authorization': `Bearer ${this.token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        };
    }

    /**
     * Fetch core1events (facility requests)
     * @returns {Promise<Array>}
     */
    async getCore1Events() {
        try {
            const response = await fetch(`${this.baseUrl}/api/core1events`, {
                method: 'GET',
                headers: this.getHeaders(),
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`API Error: ${response.status} - ${errorText}`);
            }

            const data = await response.json();
            // Handle both array and object with data property
            return Array.isArray(data) ? data : (data.data || data.events || []);
        } catch (error) {
            console.error('Error fetching core1events:', error);
            throw error;
        }
    }

    /**
     * Update event status
     * @param {string|number} eventbookingID - The event booking ID
     * @param {string} status - Status value: "APPROVED", "DECLINED", or "COMPLIANCE"
     * @returns {Promise<Object>}
     */
    async updateEventStatus(eventbookingID, status) {
        try {
            const response = await fetch(`${this.baseUrl}/api/eventapproved/${eventbookingID}`, {
                method: 'PUT',
                headers: this.getHeaders(),
                body: JSON.stringify({
                    status: status
                }),
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`API Error: ${response.status} - ${errorText}`);
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error updating event status:', error);
            throw error;
        }
    }
}

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SolieraApiClient;
}

// Make available globally
window.SolieraApiClient = SolieraApiClient;

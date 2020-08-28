import React, { Component } from 'react'
import PropTypes from 'prop-types'
import { connect } from 'react-redux'
http://localhost:8000/api/blog_posts

export class test extends Component {
    static propTypes = {
        prop: PropTypes
    }

    render() {
        return (
            <div>
                
            </div>
        )
    }
}

const mapStateToProps = (state) => ({
    
})

const mapDispatchToProps = {
    
}

export default connect(mapStateToProps, mapDispatchToProps)(test)

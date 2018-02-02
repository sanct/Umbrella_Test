require('../css/app.scss');
import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import swal from 'sweetalert';

const App = props => (
    <div className="app">
        <UrlListContainer />
    </div>
);

class UrlListContainer extends React.Component
{
    constructor(props) {
        super(props);
        this.addUrl = this.addUrl.bind(this);
        this.urlClick = this.urlClick.bind(this);
        this.handleOriginalChange = this.handleOriginalChange.bind(this);
        this.state = {
            original_url: '',
            short_url: '',
            urls: [{
                original: 'Loading data...'
            }]
        };
    }

    addUrl(event){
        event.preventDefault();

        let
            url = {
                original: this.state.original_url,
                short: this.state.short_url,
                amount: 0
            },
            urls = this.state.urls;

        axios.post('/api/urls', url)
            .then((response) => {
                url.short = response.data.short;
                urls.push(url);
                this.setState({ urls: urls});
            })
            .catch(function (error) {
                swal('Error', error.response.data);
            });

        this.setState({ original_url: '', short_url: '' });
        this.refs.url_form.reset();
    }

    urlClick(value){
        this.state.urls[value].amount++;
        this.forceUpdate();
    }

    handleOriginalChange (evt) {
        this.setState({ original_url: evt.target.value });
    };

    loadUrls() {
        axios.get('/api/urls')
            .then((response) => {
                this.setState({ urls: response.data })
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    componentWillMount() {};
    componentDidMount() {
        this.loadUrls();
    };
    componentWillReceiveProps(nextProps) {};
    shouldComponentUpdate(nextProps, nextState) {
        return true;
    };
    componentWillUpdate(nextProps, nextState) {};
    componentDidUpdate(prevProps, prevState) {};
    componentWillUnmount() {};
    render() {
        const original_url = this.state.original_url,
              isEnabled = original_url.length > 0;

        return (
            <div>
                <form className="urlForm" ref="url_form">
                    <h2>Generate short url</h2>

                    <div className='form-group'>
                        <label className="control-label required" htmlFor="original_url">Original url</label>
                        <div>
                            <input
                                type="text"
                                className="form-control"
                                value={this.state.original_url}
                                onChange={this.handleOriginalChange}
                                id="original_url"

                            />
                        </div>
                    </div>

                    <div className='form-group'>
                        <label className="control-label" htmlFor="short_url">Short url (optional)</label>
                        <div >
                            <input type="text" value={this.state.short_url} className="form-control" id="short_url"/>
                        </div>
                    </div>

                    <button className='btn btn-primary' disabled={!isEnabled} onClick={this.addUrl}> Add url</button>
                </form>
                <br/><br/>
                <table className="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Original url</th>
                        <th scope="col">Short url</th>
                        <th scope="col">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    {
                        this.state.urls.map((url, index) =>
                        <tr key={index}>
                            <td>{url.original}</td>
                            <td><a href={url.short} target="_blank" onClick={this.urlClick.bind(null, index)}>{url.short}</a></td>
                            <td>{url.amount}</td>
                        </tr>)
                    }
                    </tbody>
                </table>
            </div>
        );
    };
}

ReactDOM.render(
    <App />, document.getElementById('container')
);
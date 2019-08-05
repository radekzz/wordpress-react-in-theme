class MyForm extends React.Component {
  //for state you MUST have a constructor
  //as well as super()
  //remember to pass in props
  constructor(props) {
		super(props);
		this.state = personData;

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleChange(event) {
    console.log(event.target)
    //handles change in the input's value
    const value = event.target.value;
    const name = event.target.name;
    this.setState({ [name]: value });
    console.log(name + ': ' + value);
  }

  handleSubmit(event) {
    event.preventDefault();
    //display message and name to user
    this.setState({
      showComponent: true,
  })
  }
  render() {
    const formStyle = {
      marginBottom: 70,
    };
    return (
      <div>
        <h1>Who you are?</h1>
        <form
          onSubmit={this.handleSubmit}
          style={formStyle}
        >
          <p>
            <label for="yourName">Name:</label>
            <input
              type="text"
              id="yourName"
              name="yourName"
              size="30"
              value={this.state.yourName}
              onChange={this.handleChange.bind(this)}
            />
          </p>
          <p>
            <label for="yourWebsite">Website:</label>
            <input
              type="text"
              id="yourWebsite"
              name="yourWebsite"
              size="32"
              value={this.state.yourWebsite}
              onChange={this.handleChange.bind(this)}
            />
          </p>
          <p>
            <input
                type="submit"
                value="Submit"
                id="myBtn"
                placeholder="Show me"
              />
          </p>
        </form>
        {this.state.showComponent &&
        <TableContent
          yourName={this.state.yourName}
          yourWebsite={this.state.yourWebsite}
        />}
      </div>
      );
      }
}

class TableContent extends React.Component {
  render() {
      return (
          <table>
            <tbody>
            <tr>
              <th>My name is:</th>
              <td>{this.props.yourName}</td>
            </tr>
            <tr>
              <th>My website is:</th>
              <td><a href={this.props.yourWebsite}>{this.props.yourWebsite}</a></td>
            </tr>
            </tbody>
          </table>
      )
  }
}

//now render your form
ReactDOM.render(React.createElement(MyForm, null), document.getElementById('myApp'));